<?php
// lib/procesar_codigo_recuperacion.php
session_start();
require_once("conexion.php");
require_once("funciones_auth.php");

if (!isset($_SESSION['id_recuperacion'])) {
    header("Location: ../recuperar.php");
    exit;
}

$id_usuario = $_SESSION['id_recuperacion'];
$codigo     = $_POST['codigo'] ?? '';

// 1. Validar el código usando el tipo 'RECUPERAR'
$registro = obtenerCodigoMFA($id_usuario, $codigo, 'RECUPERAR');

if (!$registro) {
    header("Location: ../verificar_recuperacion.php?error=" . urlencode("Código incorrecto."));
    exit;
}

if ($registro['usado'] == 1) {
    header("Location: ../verificar_recuperacion.php?error=" . urlencode("Código ya utilizado."));
    exit;
}

$ahora = new DateTime();
$expira = new DateTime($registro['expira_at']);

if ($ahora > $expira) {
    header("Location: ../verificar_recuperacion.php?error=" . urlencode("El código ha expirado."));
    exit;
}

// 2. Marcar como usado
marcarCodigoUsado($registro['id_codigo_mfa']); // Función existente en tu auth

// 3. Autorizar cambio de clave
// Creamos una variable de sesión "FUERTE" que permite entrar a la pantalla de nueva clave
$_SESSION['permiso_cambiar_clave'] = true;
$_SESSION['usuario_cambio_clave'] = $id_usuario;

// Limpiamos la variable anterior para mantener orden
unset($_SESSION['id_recuperacion']);

header("Location: ../nueva_clave.php");
exit;