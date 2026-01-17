<?php include("../lib/listar-mis-reservas.php")?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis reservas</title>

  <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">
</head>
<body>

<div class="wrap">
  <section class="card">
    <header class="card-header">
      <div>
        <h2>Mis reservas</h2>
        <p>Revisa tus reservas y su estado actual.</p>
      </div>
    </header>

    <div class="table-wrap ">
      <?php if (empty($reservas)): ?>
        <div class="empty">No tienes reservas registradas.</div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Tipo</th>
              <th>Fecha inicio</th>
              <th>Fecha fin</th>
              <th>Asunto</th>
              <th>Motivo</th>
              <th>Estado</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($reservas as $r): ?>
            <?php
              $estado_raw = trim(mb_strtolower($r['estado'] ?? ''));
              $badgeClass = 'badge-pendiente';

              if (in_array($estado_raw, ['aprobado','aprobada'])) $badgeClass = 'badge-aprobado';
              elseif (in_array($estado_raw, ['rechazado','rechazada'])) $badgeClass = 'badge-rechazado';
              elseif (in_array($estado_raw, ['en revisión','en revision','revision','revisión'])) $badgeClass = 'badge-revision';
              elseif ($estado_raw === 'pendiente') $badgeClass = 'badge-pendiente';
            ?>

            <tr>
              <td class="type"><?= htmlspecialchars($r['tipo']) ?></td>
              <td class="date"><?= htmlspecialchars($r['Fecha_ini']) ?></td>
              <td class="date"><?= htmlspecialchars($r['Fecha_fin']) ?></td>
              <td class="text-clip" title="<?= htmlspecialchars($r['asunto']) ?>">
                <?= htmlspecialchars($r['asunto']) ?>
              </td>
              <td class="text-clip" title="<?= htmlspecialchars($r['motivo']) ?>">
                <?= htmlspecialchars($r['motivo']) ?>
              </td>
              <td>
                <span class="badge <?= $badgeClass ?>">
                  <?= htmlspecialchars($r['estado']) ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </section>
</div>

</body>
</html>
