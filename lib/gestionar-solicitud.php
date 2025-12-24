<?php
require_once "conexion.php"; // PDO

if (!isset($_POST['id_certificado'], $_POST['accion'])) {
    exit("Solicitud inválida");
}

$id_certificado = (int) $_POST['id_certificado'];
$accion = $_POST['accion'];

if (!in_array($accion, ['aprobar', 'rechazar'])) {
    exit("Acción no permitida");
}

// Mapeo de acciones → id_estado
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
    ':id_estado'       => $id_estado,
    ':id_certificado'  => $id_certificado
]);

// Si no hubo cambios → Redirección sin enviar correo
if ($stmt->rowCount() === 0) {
    header("Location: ../panel.php?resultado=sin_cambios");
    exit;    
}

// 2. Obtener correo del solicitante
$email = $_POST['correo'];
$nombre = $_POST['nombre'];

// 3. Configurar y enviar correo
$to = $email;
$subject = "Notificación sobre tu solicitud"; // Cambio de asunto
$message = ($accion === 'aprobar') ? 'Tu solicitud ha sido aprobada.' : 'Tu solicitud ha sido rechazada.';
$headers = "From: tu_email@ejemplo.com\r\n"; // Encabezado 'From' es importante

// Enviar correo
if (mail($to, $subject, $message, $headers)) {
    // 4. Redirección final después de enviar el correo
    header("Location: ../panel.php?resultado=ok");
    exit;
} else {
    // Error al enviar el correo
    header("Location: ../panel.php?resultado=error_correo");
    exit;
}
?>