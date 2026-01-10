<?php
require_once "conexion.php"; // PDO

if (!isset($_POST['id_certificado'], $_POST['accion'])) {
    exit("Solicitud inválida");
}

$id_certificado = (int) $_POST['id_certificado'];
$accion         = $_POST['accion'];

if (!in_array($accion, ['aprobar', 'rechazar'])) {
    exit("Acción no permitida");
}

// Mapeo de acciones → id_estado (estados_certificado)
$mapaEstados = [
    'aprobar'  => 3,
    'rechazar' => 4
];

$id_estado = $mapaEstados[$accion];

// 1. Actualizar estado
$sql = "
    UPDATE solicitud_certificado
    SET id_estado = :id_estado
    WHERE id_certificado = :id_certificado
      AND id_estado = 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_estado'      => $id_estado,
    ':id_certificado' => $id_certificado
]);

// Si no hubo cambios → Redirección sin enviar correo
if ($stmt->rowCount() === 0) {
    header("Location: ../panel.php?resultado=sin_cambios");
    exit;
}

/* 
 * 🔹 BLOQUE NUEVO: insertar en pagos_residencia SOLO si:
 *   - la acción es "aprobar"
 *   - y el certificado es de residencia (id_certi = 1)
 */
if ($accion === 'aprobar') {

    // 2.1 Ver qué tipo de certificado es
    $sqlInfo = "
        SELECT id_certi
        FROM solicitud_certificado
        WHERE id_certificado = :id_certificado
        LIMIT 1
    ";
    $stmtInfo = $pdo->prepare($sqlInfo);
    $stmtInfo->execute([':id_certificado' => $id_certificado]);
    $info = $stmtInfo->fetch(PDO::FETCH_ASSOC);

    if ($info && (int)$info['id_certi'] === 1) {
        // Aquí defines el monto (fijo, o lo sacas de otra parte)
        $monto = 2000; // ejemplo: 2000 pesos

        $sqlPago = "
            INSERT INTO pagos_residencia (id_certificado, id_estado, monto, fecha_pago)
            VALUES (:id_certificado, 2, :monto, NULL)
        ";
        // 2 = 'por pagar' en la tabla estados

        $stmtPago = $pdo->prepare($sqlPago);
        $stmtPago->execute([
            ':id_certificado' => $id_certificado,
            ':monto'          => $monto
        ]);
    }
}

// 3. Obtener correo del solicitante
$email  = $_POST['correo'];
$nombre = $_POST['nombre'];

// 4. Configurar y enviar correo
$to      = $email;
$subject = "Notificación sobre tu solicitud";
$message = ($accion === 'aprobar')
    ? 'Tu solicitud ha sido aprobada.'
    : 'Tu solicitud ha sido rechazada.';
$headers = "From: tu_email@ejemplo.com\r\n";

// Enviar correo
if (mail($to, $subject, $message, $headers)) {
    header("Location: ../panel.php?resultado=ok");
    exit;
} else {
    header("Location: ../panel.php?resultado=error_correo");
    exit;
}
?>
