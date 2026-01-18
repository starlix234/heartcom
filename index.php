<?php include "lib/mostrar-proyecto-index.php"?>
<?php include "lib/roles.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilos-2.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>heartcom</title>
</head>
<body>
<header>
<h1>Bienvenido a HeartCom</h1>

</header>
<section>
<div class="row">
<h2>Ultimos Proyectos</h2>
<?php foreach ($proyectos as $proyecto): ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100" style="width: 18rem;">
            

            <div class="card-body">
                <h5 class="card-title">
                    <?= htmlspecialchars($proyecto['nombre_proyecto']) ?>
                </h5>

                <p class="card-text">
                    <?= htmlspecialchars($proyecto['descripcion']) ?>
                </p>

                <p class="card-text">
                    <small class="text-muted">
                        Inicio: <?= date('d-m-Y', strtotime($proyecto['fecha_inicio'])) ?><br>
                        Fin: <?= date('d-m-Y', strtotime($proyecto['fecha_fin'])) ?>
                    </small>
                </p>

                <?php if ($rol === 1 || $rol === 2 || $rol==3): ?>
                <a href="modulo-proyecto/proyecto-detalle.php?id=<?= (int)$proyecto['id_proyecto'] ?>" class="btn btn-dark btn-sm">
                  Ver detalles
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
</section>

<section>
<h2>Noticias </h2>



</section>

</body>
</html>