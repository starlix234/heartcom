<?php
include("../lib/mostra-proyectos.php");
$proyectos = (isset($proyectos) && is_array($proyectos)) ? $proyectos : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyectos</title>

  <!-- Bootstrap para grid/cards -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tus estilos existentes -->
  <link rel="stylesheet" href="../assets/css/estilos.css">
  <link rel="stylesheet" href="../assets/css/estilo-formulario.css">
</head>

<body class="bg-light">

<main class="container my-4">

  <!-- Header tipo “Mis solicitudes” -->
  <section class="bg-white rounded-4 shadow-sm p-4 mb-4">
    <h2 class="mb-1">Proyectos</h2>
    <p class="text-muted mb-0">Explora los proyectos disponibles y revisa sus detalles.</p>
  </section>

  <?php if (empty($proyectos)): ?>
    <div class="bg-white rounded-4 shadow-sm p-4 text-center text-muted">
      No hay proyectos para mostrar.
    </div>
  <?php else: ?>

    <div class="row g-3">
      <?php foreach ($proyectos as $p): ?>
        <?php
          $nombre = htmlspecialchars($p['nombre_proyecto'] ?? '');
          $desc   = htmlspecialchars($p['descripcion'] ?? '');
          $ini    = htmlspecialchars($p['fecha_inicio'] ?? '');
          $fin    = htmlspecialchars($p['fecha_fin'] ?? '');
          $resp   = htmlspecialchars($p['responsable'] ?? '');
          $cupo   = htmlspecialchars($p['cupo_maximo'] ?? '');
          $tipo   = htmlspecialchars($p['nombre_tipo'] ?? '');
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <article class="bg-white rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex justify-content-between align-items-start gap-2">
              <h5 class="mb-1"><?= $nombre ?></h5>
              <span class="badge text-bg-secondary"><?= $tipo ?></span>
            </div>

            <p class="text-muted mb-3" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
              <?= $desc ?>
            </p>

            <div class="small text-muted mb-2">
              <div><strong>Inicio:</strong> <?= $ini ?: '—' ?></div>
              <div><strong>Fin:</strong> <?= $fin ?: '—' ?></div>
            </div>

            <div class="small text-muted mb-3">
              <div><strong>Responsable:</strong> <?= $resp ?: '—' ?></div>
              <div><strong>Cupo:</strong> <?= $cupo ?: '—' ?></div>
            </div>

            <!-- (Opcional) Botón ver detalles / postular -->
            <div class="d-grid">
              <a href="#" class="btn btn-outline-dark btn-sm disabled" aria-disabled="true">
                Ver detalles
              </a>
            </div>

          </article>
        </div>

      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
