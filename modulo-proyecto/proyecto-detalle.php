<?php
// ===============================
// proyecto-detalle.php (VISTA DETALLE + BOTON POSTULAR)
// ===============================
//session_start();
include('../lib/lib-mostrar-detalle-proyecto.php'); // debe dejar listas: $proyecto y las vars $nombre $tipo $estado $desc $ini $fin $resp $cupo
include("../lib/roles-proyectos.php");

// Mensaje opcional por GET
$msg = isset($_GET['msg']) ? trim($_GET['msg']) : '';
$msg = $msg ? htmlspecialchars($msg) : '';

// Validación mínima por si el include no trae datos
$idProyecto = isset($proyecto['id_proyecto']) ? (int)$proyecto['id_proyecto'] : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $nombre ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/estilos.css">
  <link rel="stylesheet" href="../assets/css/estilo-formulario.css">
</head>
<body class="bg-light">

<main class="container my-4">

  <!-- Card detalle del proyecto -->
  <section class="bg-white rounded-4 shadow-sm p-4 mb-3">
    <div class="d-flex justify-content-between align-items-start gap-2">
      <div>
        <h2 class="mb-1"><?= $nombre ?></h2>
        <div class="text-muted small">
          <span class="me-2"><strong>Tipo:</strong> <?= $tipo ?></span>
          <span><strong>Estado:</strong> <?= $estado ?></span>
        </div>
      </div>
      <a href="proyectos.php" class="btn btn-outline-secondary btn-sm">Volver</a>
    </div>

    <?php if ($msg): ?>
      <div class="alert alert-info mt-3 mb-0"><?= $msg ?></div>
    <?php endif; ?>

    <hr>

    <p class="text-muted mb-3"><?= nl2br($desc) ?></p>

    <div class="row g-3 small text-muted">
      <div class="col-12 col-md-6">
        <div><strong>Inicio:</strong> <?= $ini ?: '—' ?></div>
        <div><strong>Fin:</strong> <?= $fin ?: '—' ?></div>
      </div>
      <div class="col-12 col-md-6">
        <div><strong>Responsable:</strong> <?= $resp ?: '—' ?></div>
        <div><strong>Cupo:</strong> <?= $cupo ?: '—' ?></div>
      </div>
    </div>
  </section>

  <!-- Card acción postular -->
  <section class="bg-white rounded-4 shadow-sm p-4">
    <h5 class="mb-2">Postulación</h5>
    <p class="text-muted small mb-3">
      Si postulas, tu solicitud quedará en estado <strong>pendiente</strong>.
    </p>

    <?php if (!isset($_SESSION['id_usuario'])): ?>
      <div class="alert alert-warning mb-0">
         <a href="../login.php" class="link">Debes iniciar sesión para postular</a> 
      </div>
    <?php else: ?>
      <?php if ($idProyecto <= 0): ?>
        <div class="alert alert-danger mb-0">
          No se pudo identificar el proyecto.
        </div>
      <?php else: ?>
        <?php if ($rol === 3): ?>
        <form action="../lib/postular-proyecto.php" method="POST" class="d-grid">
          <input type="hidden" name="id_proyecto" value="<?= $idProyecto ?>"> 

          <button type="submit" class="btn btn-dark">
            Postular a este proyecto
          </button>
        </form>
        <?php endif; ?>

      <?php endif; ?>
    <?php endif; ?>
  </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
