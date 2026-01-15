<?php
// --- MODO DEBUG: ACTIVAR ERRORES ---
// Esto hará que si hay un fallo, te diga en qué línea es en vez de salir blanco.
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
    
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="body bg-fondo">

    <main class="centrar">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    <div class="login-wrapper my-5">
                        <div class="card login-card shadow-lg">
                            <div class="card-body p-4">
                                <h3 class="text-center mb-4">Recuperar Contraseña</h3>
                                <p class="text-center text-muted mb-4">Ingresa tu RUT y te enviaremos un código.</p>

                                <?php if (isset($_GET['error'])): ?>
                                    <div class="alert alert-danger py-2">
                                        <?= htmlspecialchars($_GET['error']); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="lib/procesar_solicitud_recuperacion.php" method="POST">
                                    <div class="mb-3">
                                        <label for="rut" class="form-label">RUT</label>
                                        <input 
                                            type="text" 
                                            name="rut" 
                                            id="rut"
                                            class="form-control"
                                            oninput="formatearRUT(this)" 
                                            placeholder="Ej: 12.345.678-9" 
                                            required
                                        >
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Enviar Código
                                        </button>
                                        <a href="login.php" class="btn btn-outline-secondary w-100">
                                            Volver al Login
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

    <script src="assets/js/verificar-formato-rut.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>