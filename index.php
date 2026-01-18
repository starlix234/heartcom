<?php include "lib/mostrar-proyecto-index.php" ?>
<?php include "lib/roles.php" ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS (opcional) -->
    <link rel="stylesheet" href="assets/css/estilos-2.css">

    <title>HeartCom</title>
</head>

<body class="bg-light">

<!-- ================= HEADER ================= -->
<header class="bg-dark text-white text-center py-4 mb-5 shadow">
    <h1 class="mb-0">Bienvenido a HeartCom</h1>
</header>

<div class="container">

<!-- ================= PROYECTOS ================= -->
<section class="mb-5">
    <h2 class="mb-4 text-center">Últimos Proyectos</h2>

    <div class="row justify-content-center">

    <?php foreach ($proyectos as $proyecto): ?>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">
                        <?= htmlspecialchars($proyecto['nombre_proyecto']) ?>
                    </h5>

                    <p class="card-text small text-muted">
                        <?= htmlspecialchars($proyecto['descripcion']) ?>
                    </p>

                    <p class="card-text mt-auto">
                        <small class="text-muted">
                            Inicio: <?= date('d-m-Y', strtotime($proyecto['fecha_inicio'])) ?><br>
                            Fin: <?= date('d-m-Y', strtotime($proyecto['fecha_fin'])) ?>
                        </small>
                    </p>

                    <?php if ($rol === 1 || $rol === 2 || $rol === 3): ?>
                        <a href="modulo-proyecto/proyecto-detalle.php?id=<?= (int)$proyecto['id_proyecto'] ?>"
                           class="btn btn-dark btn-sm mt-2 w-100">
                            Ver detalles
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

    </div>
</section>

<!-- ================= NOTICIAS ================= -->
<section class="mb-5">
    <h2 class="mb-4 text-center">Noticias del Barrio</h2>

    

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-0
