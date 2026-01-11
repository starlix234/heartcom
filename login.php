<?php
session_start();

// Si ya está logueado, lo mandamos al panel
if (isset($_SESSION['id_usuario'])) {
    header("Location: panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - HeartCom</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

<div class="login-card">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_GET['error'])) : ?>
        <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="lib/procesar_login.php" method="POST">
        <label>RUT</label>
        <input type="text" name="rut" placeholder="Ej: 12.345.678-9" required>

        <label>Contraseña</label>
        <input type="password" name="clave" placeholder="Tu clave" required>

        <button type="submit">Ingresar</button>
    </form>
    <a href="registro.php">Registrarse</a>
</div>

</body>
</html>
