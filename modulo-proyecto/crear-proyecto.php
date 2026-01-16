<?php include('../lib/listar-tipo-proyecto.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Proyecto</title>

  <!-- (Opcional) Bootstrap si ya lo estás usando en el proyecto -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ CSS que pediste -->
  <link rel="stylesheet" href="../assets/css/estilo-formulario-dashboard.css">
</head>

<body class="bg-light">

  <main class="container my-4">

    <!-- Encabezado -->
    <section class="mb-4">
      <h1 class="mb-1">Panel de Proyectos</h1>
      <p class="text-muted mb-0">Crea y gestiona proyectos del barrio.</p>
    </section>

    <!-- Card / Form -->
    <section class="bg-white rounded-4 shadow-sm p-4">

      <h2 class="mb-3">Crear nuevo proyecto</h2>

      <form action="../lib/guardar-proyecto.php" method="POST" class="row g-3">

        <div class="col-12">
          <label class="form-label">Nombre del proyecto</label>
          <input type="text" name="nombre_proyecto" class="form-control" required>
        </div>

        <div class="col-12">
          <label class="form-label">Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" required></textarea>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Fecha inicio</label>
          <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Fecha fin</label>
          <input type="date" name="fecha_fin" class="form-control">
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Tipo de proyecto</label>
          <select name="id_tipo_proyecto" class="form-select" required>
            <option value="">Seleccione tipo</option>
            <?php if (!empty($tipos) && is_array($tipos)): ?>
              <?php foreach ($tipos as $t): ?>
                <option value="<?= (int)$t['id_tipo_proyecto'] ?>">
                  <?= htmlspecialchars($t['nombre_tipo'] ?? '') ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="col-12 col-md-6">
          <label class="form-label">Presupuesto estimado</label>
          <input type="number" name="presupuesto_estimado" class="form-control" value="0" min="0">
        </div>

        <div class="col-12 col-md-8">
          <label class="form-label">Dirección del proyecto</label>
          <input type="text" name="direccion_proyecto" class="form-control">
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label">Cupo máximo</label>
          <input type="number" name="cupo_maximo" class="form-control" value="0" min="0">
        </div>

        <div class="col-12 d-flex gap-2 mt-2">
          <button type="submit" name="guardar" class="btn btn-primary">
            Guardar proyecto
          </button>

          <a href="mostrar-proyecto.php" class="btn btn-outline-secondary">
            Volver
          </a>
        </div>

      </form>
    </section>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


