<?php
// /verificar_codigo.php
session_start();

if (!isset($_SESSION['pending_mfa_user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar código</title>
</head>
<body>
    <h2>Verificación de código</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <p>Se ha enviado un código de verificación a tu correo.</p>

    <form action="procesar_codigo.php" method="POST">
        <label>Código:</label>
        <input type="text" name="codigo" required>
        <button type="submit">Confirmar</button>
    </form>
</body>
</html>
