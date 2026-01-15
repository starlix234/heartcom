<?php
// lib/guardar_nueva_clave.php
session_start();
require_once("conexion.php");

// Seguridad estricta
if (!isset($_SESSION['permiso_cambiar_clave']) || !isset($_SESSION['usuario_cambio_clave'])) {
    die("Acceso denegado.");
}

$clave1 = $_POST['clave1'];
$clave2 = $_POST['clave2'];
$id_usuario = $_SESSION['usuario_cambio_clave'];

if ($clave1 !== $clave2) {
    echo "<script>alert('Las contraseñas no coinciden'); window.history.back();</script>";
    exit;
}

// Encriptar contraseña (IMPORTANTE: Usa el mismo método que en registro.php)
// Si en registro usas password_hash, úsalo aquí. 
// Si guardas texto plano (no recomendado pero visto en tu código), úsalo directo.
// Asumiremos password_hash por seguridad estándar:
$clave_hash = password_hash($clave1, PASSWORD_DEFAULT);

// Si tu sistema usa texto plano (veo que login.php compara hash O texto plano), 
// puedes guardar $clave1 directamente si prefieres mantener consistencia con tu sistema actual,
// pero recomiendo hash.
// $clave_final = $clave1; // Descomentar si NO usas hash

try {
    $sql = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$clave_hash, $id_usuario]); // Usa $clave1 si no usas hash

    // Limpiar sesión completa para obligar a loguearse de nuevo
    session_destroy();

    echo "<script>
        alert('Contraseña cambiada con éxito. Por favor inicia sesión.');
        window.location.href = '../login.php';
    </script>";

} catch (Exception $e) {
    echo "Error al actualizar la clave.";
}