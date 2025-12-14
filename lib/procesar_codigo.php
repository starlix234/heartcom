<?php
// /procesar_codigo.php
session_start();
require_once("funciones_auth.php");

if (!isset($_SESSION['pending_mfa_user'])) {
    header("Location:../login.php");
    exit;
}

$id_usuario = (int) $_SESSION['pending_mfa_user'];
$codigo     = $_POST['codigo'] ?? '';

if ($codigo === '') {
    header("Location: verificar_codigo.php?error=" . urlencode("Debes ingresar el código."));
    exit;
}

// 1) Buscar el código en BD
$registro = obtenerCodigoMFA($id_usuario, $codigo);

if (!$registro) {
    header("Location: verificar_codigo.php?error=" . urlencode("Código inválido."));
    exit;
}

if ((int)$registro['usado'] === 1) {
    header("Location: verificar_codigo.php?error=" . urlencode("Este código ya fue utilizado."));
    exit;
}

// 2) Revisar expiración
$ahora  = new DateTime();
$expira = new DateTime($registro['expira_at']);

if ($ahora > $expira) {
    header("Location: verificar_codigo.php?error=" . urlencode("El código ha expirado. Inicia sesión de nuevo."));
    exit;
}

// 3) Marcar código como usado
marcarCodigoUsado((int)$registro['id_codigo_mfa']);

// 4) Crear sesión definitiva
$_SESSION['id_usuario'] = $id_usuario;
unset($_SESSION['pending_mfa_user']);

// 5) Ir al panel
header("Location:../index.php");
exit;
