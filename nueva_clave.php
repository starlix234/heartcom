<?php 
session_start(); 

// Seguridad: Si no tiene permiso, lo mandamos al login
if (!isset($_SESSION['permiso_cambiar_clave']) || !isset($_SESSION['usuario_cambio_clave'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - HeartCom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h3 class="text-center mb-3">Crear Nueva Contraseña</h3>
    <p class="text-muted text-center small">Ingresa tu nueva clave segura.</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    <form action="lib/guardar_nueva_clave.php" method="POST">
        
        <div class="mb-3">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" name="clave1" class="form-control" required placeholder="Mínimo 8 caracteres">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Repetir Contraseña</label>
            <input type="password" name="clave2" class="form-control" required placeholder="Repítela igual">
        </div>

        <div class="alert alert-info py-2" style="font-size: 0.85rem;">
            <strong>Requisitos:</strong>
            <ul class="mb-0 ps-3">
                <li>Mínimo 8 caracteres</li>
                <li>Una Mayúscula y una Minúscula</li>
                <li>Al menos un Número</li>
            </ul>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Actualizar Clave</button>
        </div>
    </form>
</div>

</body>
</html>