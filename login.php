<?php
session_start();

// Si ya está logueado, lo mandamos al panel
if (isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Capturamos posible mensaje de error por GET
$mensajeError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - HeartCom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
    <!-- Scripts de validación -->
    <script src="assets/js/verificar-formato-rut.js"></script>
</head>
<body class="body bg-fondo">

    <main class="centrar">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    <div class="login-wrapper my-5">
                        <div class="card login-card shadow-lg">
                            <div class="card-body p-4">
                                <h3 class="text-center mb-4">Iniciar Sesión</h3>

                                <?php if ($mensajeError): ?>
                                    <div class="alert alert-danger py-2">
                                        <?= htmlspecialchars($mensajeError); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="lib/procesar_login.php" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="rut" class="form-label">RUT</label>
                                        <input type="text" class="form-control" id="rut" name="rut" 
                                        oninput="formatearRUT(this)" maxlength="12" placeholder="Ej: 12.345.678-9" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="clave" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="clave" name="clave" placeholder="Tu clave" required>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                                        <a href="registro.php" class="btn btn-outline-primary w-100">Registrarse</a>
                                    </div>

                                    <div class="text-end mt-3">
                                        <a href="recuperar.php" class="text-danger text-decoration-none fw-semibold">
                                            ¿Olvidaste tu contraseña?
                                        </a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>