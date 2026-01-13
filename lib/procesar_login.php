<?php
// procesar_login.php
session_start();
require_once __DIR__ . '/funciones_auth.php';

$rut   = trim($_POST['rut']   ?? '');
$clave = $_POST['clave']      ?? '';

if ($rut === '' || $clave === '') {
    header("Location: ../login.php?error=" . urlencode("Debes ingresar RUT y contraseña."));
    exit;
}

// 1) Buscar usuario por RUT
$usuario = obtenerUsuarioPorRut($rut);

if (!$usuario) {
    header("Location: ../login.php?error=" . urlencode("RUT o contraseña incorrectos."));
    exit;
}

// 2) Verificar si el correo está validado
if ((int)$usuario['email_verificado'] === 0) {
    header("Location: ../login.php?error=" . urlencode("Debes verificar tu correo antes de iniciar sesión."));
    exit;
}

// 3) Verificar contraseña usando hash + migración de claves viejas
$ok = verificarClaveLogin($clave, $usuario);

if (!$ok) {
    header("Location: ../login.php?error=" . urlencode("RUT o contraseña incorrectos."));
    exit;
}

// 4) Generar código MFA para login
$id_usuario = (int)$usuario['id_usuario'];
$codigo     = crearCodigoMFA($id_usuario);

// Enviar código al correo del usuario
$correo = $usuario['correo'] ?? '';
if (!empty($correo)) {
    enviarCorreoCodigo($correo, $codigo);
}

// 5) Guardar estado pendiente de MFA en sesión
$_SESSION['pending_mfa_user'] = $id_usuario;

// 6) Redirigir a la página de verificación de código
header("Location: verificar_codigo.php");
exit;
