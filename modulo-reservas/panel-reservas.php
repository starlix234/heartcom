<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
</head>
<body>
<div class="container mt-3">
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong>⚠️ Atención:</strong> <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>✅ ¡Listo!</strong> <?= htmlspecialchars($_GET['msg']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

</div>
<?php include('crear-espacio-reserva.php')?>
<?php include('mostrar-reserva.php')?>

<?php include('administrar-reservas.php') ?>

<div class="container mt-3">
    <a href="../panel.php" class="btn btn-outline-secondary btn-sm">
        &larr; Volver al Panel
    </a>
</div>
</body>
</html>