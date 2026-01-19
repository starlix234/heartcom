<?php include('../lib/mostrar-postulaciones.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrar Postulaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
  <h2 class="mb-3">Administrar Postulaciones</h2>

  <?php if (empty($postulaciones)): ?>
    <div class="alert alert-secondary">No hay postulaciones registradas.</div>
  <?php else: ?>
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Postulante</th>
            <th>Proyecto</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Obs.</th>
            <th class="text-end">Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($postulaciones as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['postulante']) ?></td>
            <td><?= htmlspecialchars($p['nombre_proyecto']) ?></td>
            <td><span class="badge bg-primary"><?= htmlspecialchars($p['estado_postulacion']) ?></span></td>
            <td><?= htmlspecialchars($p['fecha_postulacion']) ?></td>
            <td><?= htmlspecialchars($p['observacion_admin'] ?? '—') ?></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary"
                 href="detalle-postulacion.php?id_postulacion=<?= (int)$p['id_postulacion'] ?>">
                 Administrar
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
