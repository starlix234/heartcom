<?php
session_start();
require_once('conexion.php');

$p_nombre    = trim($_POST['p_nombre'] ?? '');
$s_nombre    = trim($_POST['s_nombre'] ?? '');
$ap_paterno  = trim($_POST['ap_paterno'] ?? '');
$ap_materno  = trim($_POST['ap_materno'] ?? '');
$fecha_nac   = $_POST['fecha_nac'] ?? '';
$rut         = trim($_POST['rut'] ?? '');
$telefono    = trim($_POST['telefono'] ?? '');
$correo      = trim($_POST['correo'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$clave       = $_POST['clave'] ?? '';

// 1️⃣ Validación de campos obligatorios
if (
    !$p_nombre || !$s_nombre || !$ap_paterno || !$ap_materno ||
    !$fecha_nac || !$rut || !$telefono || !$correo || !$direccion || !$clave
) {
    header("Location: registro.php?error=" . urlencode("Completa todos los campos."));
    exit;
}

// 2️⃣ Validar formato de correo (SOLO gmail.com o hotmail.com)
$correo = strtolower($correo);

if (!preg_match('/^[a-z0-9._%+-]+@(gmail\.com|hotmail\.com)$/', $correo)) {
    header("Location: registro.php?error=" . urlencode(
        "Solo se permiten correos Gmail o Hotmail."
    ));
    exit;
}

// 3️⃣ Validar que RUT o correo no existan
$stmt = $pdo->prepare("
    SELECT id_usuario 
    FROM usuarios 
    WHERE rut = ? OR correo = ?
");
$stmt->execute([$rut, $correo]);

if ($stmt->fetch()) {
    header("Location: registro.php?error=" . urlencode(
        "El RUT o el correo ya están registrados."
    ));
    exit;
}

// 4️⃣ Hash de contraseña
$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

// 5️⃣ Token de verificación
$token  = bin2hex(random_bytes(32));
$expira = (new DateTime('+1 day'))->format('Y-m-d H:i:s');

// 6️⃣ Insertar usuario
$stmt = $pdo->prepare("
    INSERT INTO usuarios (
        p_nombre, s_nombre, ap_paterno, ap_materno, fecha_nac,
        rut, telefono, correo,
        email_verificado, email_token, email_token_expira,
        direccion, clave, id_rol
    ) VALUES (
        ?, ?, ?, ?, ?,
        ?, ?, ?,
        0, ?, ?,
        ?, ?, 3
    )
");

$stmt->execute([
    $p_nombre,
    $s_nombre,
    $ap_paterno,
    $ap_materno,
    $fecha_nac,
    $rut,
    $telefono,
    $correo,
    $token,
    $expira,
    $direccion,
    $clave_hash
]);

// 7️⃣ Enviar correo de verificación
$enlace = "http://localhost/barrio3/lib/verificar_correo.php?token=$token";

$asunto = "Verifica tu cuenta - Junta de Vecinos";
$mensaje = "Hola $p_nombre,

Para activar tu cuenta, haz clic en el siguiente enlace:
$enlace

Este enlace expira en 24 horas.
";

$headers  = "From: Junta de Vecinos <no-reply@barrio3.local>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

@mail($correo, $asunto, $mensaje, $headers);

// 8️⃣ Redirección final
header("Location: ../login.php?msg=" . urlencode(
    "Registro exitoso. Revisa tu correo para verificar la cuenta."
));
exit;
