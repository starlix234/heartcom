<?php
// /procesar_login.php
session_start();
require_once("funciones_auth.php");
$rut   = $_POST['rut']   ?? '';
$clave = $_POST['clave'] ?? '';

if ($rut === '' || $clave === '') {
    header("Location: login.php?error=" . urlencode("Debes ingresar RUT y contraseña."));
    exit;
}

// 1) Buscar usuario por RUT
$usuario = obtenerUsuarioPorRut($rut);

if (!$usuario) {
    header("Location: login.php?error=" . urlencode("RUT o contraseña incorrectos."));
    exit;
}

// 2) Verificar si el correo está validado
if ($usuario['email_verificado'] == 0) {
    header("Location: login.php?error=" . urlencode("Debes verificar tu correo antes de iniciar sesión."));
    exit;
}

// 3) Verificar contraseña (hash primero)
$claveBd = $usuario['clave'];
$ok = password_verify($clave, $claveBd) || ($clave === $claveBd && strlen($claveBd) <= 50);

if (!$ok) {
    header("Location: login.php?error=" . urlencode("RUT o contraseña incorrectos."));
    exit;
}

// 4) Generar código MFA para login
$id_usuario = (int)$usuario['id_usuario'];
$codigo = crearCodigoMFA($id_usuario);

// Enviar código al correo
$correo = $usuario['correo'];
enviarCorreoCodigo($correo, $codigo);

// 5) Guardar estado pendiente MFA
$_SESSION['pending_mfa_user'] = $id_usuario;

// 6) Ir a verificación MFA
header("Location: verificar_codigo.php");
exit;