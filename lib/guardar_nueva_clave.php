<?php
session_start();
require_once 'conexion.php';

// 1. Seguridad de sesión
if (!isset($_SESSION['permiso_cambiar_clave']) || !isset($_SESSION['usuario_cambio_clave'])) {
    header("Location: ../login.php");
    exit;
}

$clave1 = $_POST['clave1'] ?? '';
$clave2 = $_POST['clave2'] ?? '';
$idUsuario = $_SESSION['usuario_cambio_clave'];

// 2. Validar campos vacíos
if (empty($clave1) || empty($clave2)) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Por favor completa ambos campos."));
    exit;
}

// 3. Validar que sean IGUALES
if ($clave1 !== $clave2) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Las contraseñas no coinciden."));
    exit;
}

// 4. VALIDACIÓN DE REQUISITOS (Seguridad)

// A) Longitud (Mínimo 8)
if (strlen($clave1) < 8) {
    header("Location: ../nueva_clave.php?error=" . urlencode("La contraseña es muy corta. Mínimo 8 caracteres."));
    exit;
}
if (strlen($clave1) > 15){
    header("Location: ../nueva_clave.php?error=" . urldecode("La contraseña es muy larga. Maximo 15 caracteres."));
    exit;
}

// B) Minúscula
if (!preg_match('/[a-z]/', $clave1)) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Falta al menos una letra minúscula."));
    exit;
}

// C) Mayúscula
if (!preg_match('/[A-Z]/', $clave1)) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Falta al menos una letra MAYÚSCULA."));
    exit;
}

// D) Número
if (!preg_match('/[0-9]/', $clave1)) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Falta al menos un número."));
    exit;
}

try {
    // 5. Todo correcto: Encriptar y Guardar
    $claveHash = password_hash($clave1, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE usuarios SET clave = ? WHERE id_usuario = ?");
    $stmt->execute([$claveHash, $idUsuario]);

    // 6. Limpiar y salir
    session_destroy(); // Cerramos sesión para obligar a entrar con la nueva clave
    
    // Enviamos mensaje de éxito al login
    header("Location: ../login.php?msg=" . urlencode("¡Clave actualizada correctamente! Inicia sesión."));
    exit;

} catch (PDOException $e) {
    header("Location: ../nueva_clave.php?error=" . urlencode("Error del sistema. Intenta más tarde."));
    exit;
}
?>