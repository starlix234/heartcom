<?php 
session_start(); 
if (!isset($_SESSION['id_recuperacion'])) {
    header("Location: recuperar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

<div class="login-card">
    <h2>Ingresa el Código</h2>
    <p>Revisa tu correo electrónico.</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error" style="color:red;"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="lib/procesar_codigo_recuperacion.php" method="POST">
        <label>Código de 6 dígitos</label>
        <input type="text" name="codigo" required autocomplete="off">
        <button type="submit">Verificar</button>
    </form>
</div>

</body>
</html>