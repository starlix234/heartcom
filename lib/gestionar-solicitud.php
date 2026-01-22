<?php
require_once "conexion.php"; // PDO

// 1️⃣ Validar POST obligatorio
if (
    !isset($_POST['id_certificado'], $_POST['accion'], $_POST['correo'], $_POST['nombre'])
) {
    exit("Solicitud inválida");
}

$id_certificado = (int) $_POST['id_certificado'];
$accion         = $_POST['accion'];
$email          = $_POST['correo'];
$nombre         = $_POST['nombre'];

// 2️⃣ Validar acción permitida
$mapaEstados = [
    'aprobar'  => 3, // aprobado
    'rechazar' => 4  // rechazado
];

if (!array_key_exists($accion, $mapaEstados)) {
    exit("Acción no permitida");
}

$id_estado_nuevo = $mapaEstados[$accion];

// 3️⃣ Verificar que la solicitud EXISTA y esté en estado "solicitado"
$sqlCheck = "
    SELECT id_estado, id_certi
    FROM solicitud_certificado
    WHERE id_certificado = :id_certificado
    LIMIT 1
";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':id_certificado' => $id_certificado]);
$solicitud = $stmtCheck->fetch(PDO::FETCH_ASSOC);

if (!$solicitud) {
    header("Location: ../modulo-certificados/administrar-certificados.php?resultado=no_existe");
    exit;
}

if ((int)$solicitud['id_estado'] !== 1) {
    // No está en estado solicitado
    header("Location: ../modulo-certificados/administrar-certificados.php?resultado=estado_invalido");
    exit;
}

// 4️⃣ Actualizar estado (YA VALIDADO)
$sqlUpdate = "
    UPDATE solicitud_certificado
    SET id_estado = :id_estado
    WHERE id_certificado = :id_certificado
";
$stmtUpdate = $pdo->prepare($sqlUpdate);
$stmtUpdate->execute([
    ':id_estado'      => $id_estado_nuevo,
    ':id_certificado' => $id_certificado
]);

// 5️⃣ Si se aprueba y es certificado de residencia → crear pago
if ($accion === 'aprobar' && (int)$solicitud['id_certi'] === 1) {

    $monto = 2000; // monto fijo

    $sqlPago = "
        INSERT INTO pagos_residencia (id_certificado, id_estado, monto, fecha_pago)
        VALUES (:id_certificado, 2, :monto, NULL)
    ";
    // 2 = por pagar

    $stmtPago = $pdo->prepare($sqlPago);
    $stmtPago->execute([
        ':id_certificado' => $id_certificado,
        ':monto'          => $monto
    ]);
}

// 6️⃣ Enviar correo
$subject = "Notificación sobre tu solicitud";
$message = ($accion === 'aprobar')
    ? "Hola $nombre,\n\nTu solicitud ha sido APROBADA."
    : "Hola $nombre,\n\nTu solicitud ha sido RECHAZADA.";

$headers = "From: no-reply@tusistema.cl\r\n";

if (mail($email, $subject, $message, $headers)) {
    header("Location: ../modulo-certificados/administrar-certificados.php?resultado=ok");
} else {
    header("Location: ../modulo-certificados/administrar-certificados.php?resultado=error_correo");
}
exit;
