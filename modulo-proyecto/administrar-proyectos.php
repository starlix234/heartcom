<?php
include("../lib/mostrar-proyecto-admin.php");

// Blindaje: si mostrar-proyecto-admin.php no setea $proyecto o viene null
$proyecto = (isset($proyecto) && is_array($proyecto)) ? $proyecto : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Proyectos</title>

  <!-- (Opcional pero recomendado) Bootstrap para grillas/tablas -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Iconos para acciones tipo la referencia -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- ✅ Tus estilos existentes del repo (no invento nombres) -->
  <link rel="stylesheet" href="../assets/css/estilos.css">
  <link rel="stylesheet" href="../assets/css/estilo-formulario.css">
</head>

<body class="bg-light">

  <main class="container my-4">
    <!-- Card estilo “Mis solicitudes” -->
    <section class="bg-white rounded-4 shadow-sm p-4">

      <div class="mb-3">
        <h2 class="mb-1">Gestión de Proyectos</h2>
        <p class="text-muted mb-0">Revisa los proyectos, aprueba o rechaza según corresponda.</p>
      </div>

      <div class="table-responsive">
        <table class="table table-borderless align-middle mb-0">
          <thead class="border-bottom">
            <tr class="text-muted small">
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th>Responsable</th>
              <th>Cupo</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>

          <tbody class="border-top-0">
            <?php if (empty($proyecto)): ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-4">No hay proyectos para mostrar.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($proyecto as $pr): ?>
                <?php $estado = trim(mb_strtolower($pr['nombre_estado'] ?? '', 'UTF-8')); ?>
                <tr class="border-bottom">
                  <td class="fw-semibold"><?= htmlspecialchars($pr['nombre_proyecto'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['descripcion'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['fecha_inicio'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['fecha_fin'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['responsable'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['cupo_maximo'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['nombre_tipo'] ?? '') ?></td>
                  <td><?= htmlspecialchars($pr['nombre_estado'] ?? '') ?></td>

                  <td class="text-end">
                    <?php if ($estado === 'planificado'): ?>

                      <!-- Rechazar -->
                      <form action="../lib/procesar-proyecto.php" method="POST" class="d-inline">
                        <input type="hidden" name="id_proyecto" value="<?= (int)($pr['id_proyecto'] ?? 0) ?>">
                        <input type="hidden" name="accion" value="rechazar">
                        <button type="submit" class="btn btn-link p-0 text-decoration-none"
                                title="Rechazar"
                                onclick="return confirm('¿Rechazar este proyecto?');">
                          <i class="bi bi-slash-circle fs-5"></i>
                        </button>
                      </form>

                      <!-- Aprobar -->
                      <form action="../lib/procesar-proyecto.php" method="POST" class="d-inline ms-2">
                        <input type="hidden" name="id_proyecto" value="<?= (int)($pr['id_proyecto'] ?? 0) ?>">
                        <input type="hidden" name="accion" value="aprobar">
                        <button type="submit" class="btn btn-link p-0 text-decoration-none"
                                title="Aprobar"
                                onclick="return confirm('¿Aprobar este proyecto?');">
                          <i class="bi bi-check-circle fs-5"></i>
                        </button>
                      </form>

                    <?php else: ?>
                      <span class="text-muted">—</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
