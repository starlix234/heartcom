<?php
// MODO DEBUG
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - HeartCom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .card-custom { border: none; border-radius: 20px; }
        .icon-header { font-size: 3rem; color: #0d6efd; margin-bottom: 10px; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                
                <div class="card card-custom shadow-lg">
                    <div class="card-body p-5 text-center">
                        
                        <div class="mb-4">
                            <i class="bi bi-shield-lock icon-header"></i>
                            <h2 class="fw-bold mt-2">¿Olvidaste tu clave?</h2>
                            <p class="text-muted small">
                                No te preocupes. Ingresa tu RUT y te enviaremos un código para recuperarla.
                            </p>
                        </div>

                        <form action="lib/procesar_recuperacion.php" method="POST" class="text-start">
                            
                            <div class="mb-4">
                                <label for="rut" class="form-label fw-semibold">RUT del Vecino</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person-vcard text-muted"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        name="rut" 
                                        id="rut"
                                        class="form-control border-start-0 ps-0"
                                        oninput="formatearRUT(this)" 
                                        placeholder="Ej: 12.345.678-9" 
                                        required
                                    >
                                </div>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    Enviar Código
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="login.php" class="text-decoration-none text-secondary small">
                                    <i class="bi bi-arrow-left"></i> Volver al inicio de sesión
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
                
                <div class="text-center mt-3 text-muted small">
                    &copy; <?= date('Y') ?> Junta de Vecinos HeartCom
                </div>

            </div>
        </div>
    </main>

    <script src="assets/js/verificar-formato-rut.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>