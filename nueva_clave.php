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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">

    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .card-custom { border: none; border-radius: 20px; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card card-custom shadow-lg">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <i class="bi bi-key fs-1 text-success"></i>
                            <h3 class="fw-bold mt-2">Nueva Contraseña</h3>
                            <p class="text-muted small">Crea una clave segura que puedas recordar.</p>
                        </div>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger small text-center rounded-3">
                                <?= htmlspecialchars($_GET['error']) ?>
                            </div>
                        <?php endif; ?>

                        <form action="lib/guardar_nueva_clave.php" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="clave1" class="form-control" required placeholder="Mínimo 8 caracteres" >
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Repetir Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="clave2" class="form-control" required placeholder="Repítela igual" >
                                </div>
                            </div>

                            <div class="alert alert-light border small py-2 mb-4 bg-light">
                                <strong class="d-block mb-1 text-secondary">Requisitos:</strong>
                                <ul class="mb-0 ps-3 text-muted" style="font-size: 0.85rem;">
                                    <li>Mínimo 8 caracteres</li>
                                    <li>Maximo 15 caracteres</li>
                                    <li>Una Mayúscula y una Minúscula</li>
                                    <li>Al menos un número</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 shadow-sm fw-bold">
                                Guardar Contraseña
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>