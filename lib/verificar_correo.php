<?php
// Mostrar errores en pantalla para saber qué pasa
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Error: Token no proporcionado.");
}

try {
    // Verificar token y expiración (usando hora del servidor SQL para evitar desfases)
    $stmt = $pdo->prepare("
        SELECT id_usuario 
        FROM usuarios 
        WHERE email_token = ? 
        AND email_token_expira > NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Mensaje amigable si falló
        die("<h3>Enlace inválido o expirado.</h3><p>Es posible que ya hayas verificado tu cuenta antes.</p><a href='../login.php'>Ir al Login</a>");
    }

    // Activar usuario
    $update = $pdo->prepare("
        UPDATE usuarios 
        SET email_verificado = 1, 
            email_token = NULL, 
            email_token_expira = NULL 
        WHERE id_usuario = ?
    ");
    $update->execute([$user['id_usuario']]);

    // Éxito
    echo "<h1>¡Cuenta Verificada! 🎉</h1>";
    echo "<p>Tu correo ha sido confirmado.</p>";
    echo "<a href='../login.php'>Iniciar Sesión</a>";

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>