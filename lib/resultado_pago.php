<?php
session_start();

$success = isset($_GET['success']) ? (int) $_GET['success'] : 0;
$idCertificado = isset($_GET['id_certificado']) ? (int) $_GET['id_certificado'] : 0;
$motivo = isset($_GET['motivo']) ? $_GET['motivo'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .card {
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .ok {
            border-color: #2e7d32;
            background: #e8f5e9;
            color: #1b5e20;
        }
        .error {
            border-color: #c62828;
            background: #ffebee;
            color: #b71c1c;
        }
        a.button {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #1976d2;
            color: #fff;
            background: #1976d2;
        }
    </style>
</head>
<body>

<?php if ($success === 1): ?>
    <div class="card ok">
        <h2>Pago realizado con éxito</h2>
        <p>Tu pago ha sido procesado correctamente.</p>

        <?php if ($idCertificado > 0): ?>
            <p>ID Certificado: <strong><?php echo htmlspecialchars($idCertificado, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <!-- Aquí llamas al script que genera/descarga el PDF -->
            <a class="button" href="descargar-certificado-residencia.php?id_certificado=<?php echo (int)$idCertificado; ?>">
                Descargar certificado
            </a>
        <?php endif; ?>

        <!-- Ajusta esta ruta según dónde tengas la vista de solicitudes del vecino -->
        <a class="button" href="../modulo-certificados/solicitud-cliente.php">Volver a mis solicitudes</a>
    </div>

<?php else: ?>
    <div class="card error">
        <h2>El pago no se completó</h2>

        <?php if ($motivo === 'abortado'): ?>
            <p>Has cancelado el pago desde Webpay.</p>
        <?php else: ?>
            <p>El pago fue rechazado o ocurrió un error al procesarlo.</p>
        <?php endif; ?>

        <?php if ($idCertificado > 0): ?>
            <p>Puedes intentarlo nuevamente desde tus solicitudes.</p>
        <?php endif; ?>

        <a class="button" href="../modulo-certificados/solicitud-cliente.php">Volver a mis solicitudes</a>
    </div>
<?php endif; ?>

</body>
</html>
