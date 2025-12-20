<?php
session_start();
require_once('conexion.php');

$p_nombre    = $_POST['p_nombre'] ?? '';
$s_nombre    = $_POST['s_nombre'] ?? '';
$ap_paterno  = $_POST['ap_paterno'] ?? '';
$ap_materno  = $_POST['ap_materno'] ?? '';
$fecha_nac   = $_POST['fecha_nac'] ?? '';
$rut         = $_POST['rut'] ?? '';
$telefono    = $_POST['telefono'] ?? '';
$correo      = $_POST['correo'] ?? '';
$direccion   = $_POST['direccion'] ?? '';
$clave       = $_POST['clave'] ?? '';

// Validación básica
if (!$p_nombre || !$s_nombre || !$ap_paterno || !$ap_materno || !$fecha_nac ||
    !$rut || !$telefono || !$correo || !$direccion || !$clave) {
    header("Location: registro.php?error=" . urlencode("Completa todos los campos."));
    exit;
}

// Validar que el RUT y correo no existan
$stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE rut = ? OR correo = ?");
$stmt->execute([$rut, $correo]);
if ($stmt->fetch()) {
    header("Location: registro.php?error=" . urlencode("RUT o correo ya registrado."));
    exit;
}




// Crear token verificación correo
$token = bin2hex(random_bytes(32));
$expira = (new DateTime('+1 day'))->format('Y-m-d H:i:s');

// Insertar nuevo miembro (rol = 3)
$stmt = $pdo->prepare("
INSERT INTO usuarios (
  p_nombre, s_nombre, ap_paterno, ap_materno, fecha_nac, estado_civil,
  rut, telefono, correo, email_verificado, email_token, email_token_expira,
  direccion, clave, id_rol
) VALUES (
  ?, ?, ?, ?, ?, NULL,
  ?, ?, ?, 0, ?, ?,
  ?, ?, 3
)
");

$stmt->execute([
    $p_nombre, $s_nombre, $ap_paterno, $ap_materno, $fecha_nac,
    $rut, $telefono, $correo, $token, $expira,
    $direccion, $clave
]);

// Enviar correo de verificación
$enlace = "http://localhost/barrio3/lib/verificar_correo.php?token=$token";

$asunto = "Verifica tu cuenta en Junta de Vecinos";
$mensaje = "Hola, por favor confirma tu correo haciendo clic aquí: $enlace";
$headers = "From: no-reply@barrio3.local\r\n";

mail($correo, $asunto, $mensaje, $headers);

// Redirigir a login con aviso
header("Location: ../login.php?msg=" . urlencode("Revisa tu correo para verificar tu cuenta."));
exit;
