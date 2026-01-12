<?php

session_start();
require_once 'conexion.php';
$_SESSION['old'] = $_POST;

// 1️⃣ Captura y limpieza de datos
$p_nombre    = trim($_POST['p_nombre'] ?? '');
$s_nombre    = trim($_POST['s_nombre'] ?? '');
$ap_paterno  = trim($_POST['ap_paterno'] ?? '');
$ap_materno  = trim($_POST['ap_materno'] ?? '');
$fecha_nac   = $_POST['fecha_nac'] ?? '';
<<<<<<< HEAD
$rut        = trim(strtoupper($_POST['rut']) ?? '');
=======
$rut  = $_POST['rut'];
>>>>>>> bbd230b94ab77f3deb2a2a438e89f9e7125b44e7
$telefono    = trim($_POST['telefono'] ?? '');
$correo      = trim($_POST['correo'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$clave       = $_POST['clave'] ?? '';


// 2️⃣ Validación de campos obligatorios
if (
    !$p_nombre || !$s_nombre || !$ap_paterno || !$ap_materno ||
    !$fecha_nac || !$rut || !$telefono || !$correo || !$direccion || !$clave
) {
    header("Location: ../registro.php?error=" . urlencode("Completa todos los campos."));
    exit;
}

//validar contraseña de 

$mensajePassword = "La contraseña debe tener entre 5 y 15 caracteres, incluir mayúscula, minúscula y número.";

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{5,15}$/', $clave)) {
    header("Location: ../registro.php?error=" . urlencode($mensajePassword));
    exit;
}

// 3️⃣ Validar formato de correo (gmail / hotmail)
$correo = strtolower($correo);
if (!preg_match('/^[a-z0-9._%+-]+@(gmail\.com|hotmail\.com)$/', $correo)) {
    header("Location: ../registro.php?error=" . urlencode(
        "Solo se permiten correos con dominio Gmail.com o Hotmail.com ."
    ));
    exit;
}

// 4️⃣ Validar edad (>= 18)
$fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fecha_nac);
$hoy = new DateTime('today');

if (!$fechaNacimiento) {
    header("Location: ../registro.php?error=" . urlencode("Fecha de nacimiento inválida."));
    exit;
}

$edad = $hoy->diff($fechaNacimiento)->y;

if ($edad < 18) {
    header("Location: ../registro.php?error=" . urlencode("Debe ser mayor de edad."));
    exit;
}




// 5️⃣ Validar RUT o correo duplicado
$stmt = $pdo->prepare("
    SELECT id_usuario
    FROM usuarios
    WHERE rut = ? OR correo = ?
");
$stmt->execute([$rut, $correo]);

if ($stmt->fetch()) {
    header("Location: ../registro.php?error=" . urlencode(
        "El RUT o el correo ya están registrados."
    ));
    exit;
}

// 6️⃣ Hash de contraseña
//$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

// 7️⃣ Token de verificación
$token  = bin2hex(random_bytes(32));
$expira = (new DateTime('+1 day'))->format('Y-m-d H:i:s');

// 8️⃣ Insertar usuario
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
    $clave
]);

// 9️⃣ Enviar correo de verificación
$enlace = "http://localhost/HEARTCOM/lib/verificar_correo.php?token=$token";

$asunto = "Verifica tu cuenta - Junta de Vecinos";
$mensaje = "Hola $p_nombre,

Para activar tu cuenta, haz clic en el siguiente enlace:
$enlace

Este enlace expira en 24 horas.
";

$headers  = "From: Junta de Vecinos <no-reply@barrio3.local>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// El @ evita warnings en local (opcional)
@mail($correo, $asunto, $mensaje, $headers);

// 🔟 Redirección final
header("Location: ../login.php?msg=" . urlencode(
    "Registro exitoso. Revisa tu correo para verificar la cuenta."
));
exit;
