<?php 
session_start(); 
if (!isset($_SESSION['permiso_cambiar_clave']) || !isset($_SESSION['usuario_cambio_clave'])) {
    header("Location: login.php"); // Seguridad: impide acceso directo
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

<div class="login-card">
    <h2>Crear Nueva Contraseña</h2>

    <form action="lib/guardar_nueva_clave.php" method="POST">
        <label>Nueva Contraseña</label>
        <input type="password" name="clave1" required minlength="4">
        
        <label>Repetir Contraseña</label>
        <input type="password" name="clave2" required minlength="4">

        <button type="submit">Cambiar Contraseña</button>
    </form>
</div>

</body>
</html>