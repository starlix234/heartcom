<?php
// ===============================
// proyectos.php (LISTADO)
// ===============================
include("../lib/mostra-proyectos.php");
$proyectos = (isset($proyectos) && is_array($proyectos)) ? $proyectos : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyectos</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/estilos.css">
  <link rel="stylesheet" href="../assets/css/estilo-formulario.css">
</head>
<body class="bg-light">
<main class="container my-4">
  <section class="bg-white rounded-4 shadow-sm p-4 mb-4">
    <h2 class="mb-1">Proyectos</h2>
    <p class="text-muted mb-0">Explora los proyectos disponibles y revisa sus detalles.</p>

    <?php if (isset($_GET['msg'])): ?>
      <div class="alert alert-info mt-3 mb-0">
        <?= htmlspecialchars($_GET['msg']) ?>
      </div>
    <?php endif; ?>
  </section>

  <?php if (empty($proyectos)): ?>
    <div class="bg-white rounded-4 shadow-sm p-4 text-center text-muted">
      No hay proyectos para mostrar.
    </div>
  <?php else: ?>

    <div class="row g-3">
      <?php foreach ($proyectos as $p): ?>
        <?php
          $idProyecto = (int)($p['id_proyecto'] ?? 0);
          $nombre = htmlspecialchars($p['nombre_proyecto'] ?? '');
          $desc   = htmlspecialchars($p['descripcion'] ?? '');
          $ini    = htmlspecialchars($p['fecha_inicio'] ?? '');
          $fin    = htmlspecialchars($p['fecha_fin'] ?? '');
          $resp   = htmlspecialchars($p['responsable'] ?? '');
          $cupo   = htmlspecialchars($p['cupo_maximo'] ?? '');
          $tipo   = htmlspecialchars($p['nombre_tipo'] ?? '');
          $estado = htmlspecialchars($p['nombre_estado'] ?? '');
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <article class="bg-white rounded-4 shadow-sm p-4 h-100">

            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <h5 class="mb-1"><?= $nombre ?></h5>
                <div class="small text-muted"><?= $estado ?: '—' ?></div>
              </div>
              <span class="badge text-bg-secondary"><?= $tipo ?: '—' ?></span>
            </div>

            <p class="text-muted mb-3 mt-2"
               style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
              <?= $desc ?>
            </p>

            <div class="small text-muted mb-2">
              <div><strong>Inicio:</strong> <?= $ini ?: '—' ?></div>
              <div><strong>Fin:</strong> <?= $fin ?: '—' ?></div>
            </div>


          </article>

          <div class="d-grid">
  <a href="proyecto-detalle.php?id=<?= $idProyecto ?>" class="btn btn-dark btn-sm">
    Ver detalles
  </a>
</div>
        </div>


      <?php endforeach; ?>
    </div>

  <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
