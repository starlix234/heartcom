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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - HeartCom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">

    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .card-custom { border: none; border-radius: 20px; }
        .input-codigo {
            letter-spacing: 5px;
            font-size: 1.5rem;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                
                <div class="card card-custom shadow-lg">
                    <div class="card-body p-5 text-center">
                        
                        <div class="mb-4">
                            <span class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-block mb-3">
                                <i class="bi bi-envelope-paper fs-1"></i>
                            </span>
                            <h3 class="fw-bold">Revisa tu Correo</h3>
                            <p class="text-muted small">
                                Hemos enviado un código de 6 dígitos a tu email asociado.
                            </p>
                        </div>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger d-flex align-items-center small" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?= htmlspecialchars($_GET['error']); ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="lib/procesar_codigo_recuperacion.php" method="POST">
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Código de Verificación</label>
                                <input type="text" name="codigo" 
                                       class="form-control form-control-lg input-codigo rounded-3" 
                                       maxlength="6" 
                                       required 
                                       autocomplete="off"
                                       placeholder="123456">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
                                Verificar Código
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="small">
                            <span class="text-muted">¿No recibiste nada?</span> 
                            <a href="recuperar.php" class="text-decoration-none fw-bold">Intentar de nuevo</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>