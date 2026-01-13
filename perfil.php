<?php
session_start();
require_once 'lib/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = (int)$_SESSION['id_usuario'];

$sql = "SELECT p_nombre, ap_paterno, telefono, correo FROM usuarios WHERE id_usuario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - HeartCom</title>
    <link rel="stylesheet" href="assets/css/estilos.css"> <style>
        .btn-volver {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-card"> <h2>Editar Perfil</h2>
    <p style="text-align:center; color:#666;">
        Hola, <strong><?= htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['ap_paterno']) ?></strong>
    </p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div style="color: green; text-align: center; margin-bottom: 10px;">
            ¡Datos actualizados correctamente!
        </div>
    <?php endif; ?>

    <form action="lib/actualizar-perfil.php" method="POST">
        
        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

        <label>Nueva Contraseña:</label>
        <input type="password" name="clave" placeholder="Dejar en blanco si no desea cambiarla">
        
        <button type="submit">Guardar Cambios</button>
    </form>

    <a href="panel.php" class="btn-volver">← Volver al Panel</a>
</div>

</body>
</html>