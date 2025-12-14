<?php
require_once ('conexion.php');

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("
    SELECT id_usuario, email_token_expira
    FROM usuarios
    WHERE email_token = ?
");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Token inválido.");
}

if (new DateTime() > new DateTime($user['email_token_expira'])) {
    die("El enlace ha expirado, solicita uno nuevo.");
}

$pdo->prepare("
    UPDATE usuarios
    SET email_verificado = 1,
        email_token = NULL,
        email_token_expira = NULL
    WHERE id_usuario = ?
")->execute([$user['id_usuario']]);

echo "<h2>Correo verificado. Ya puedes iniciar sesión 🎉</h2>";
echo "<a href='../index.php'>Ir al Login</a>";
