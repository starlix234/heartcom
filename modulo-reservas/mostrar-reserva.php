<?php include("../lib/listar-mis-reservas.php")?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis reservas</title>

  <link rel="stylesheet" href="../assets/css/estilo-tabla-reservas.css">
</head>
<body>

<div>
  <section>
    <header>
      <div>
        <p>Revisa tus reservas y su estado actual.</p>
      </div>
    </header>

    <div>
      <?php if (empty($reservas)): ?>
        <div>No tienes reservas registradas.</div>
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
              $badgeClass = '';

              if (in_array($estado_raw, ['aprobado','aprobada'])) $badgeClass = '';
              elseif (in_array($estado_raw, ['rechazado','rechazada'])) $badgeClass = '';
              elseif (in_array($estado_raw, ['en revisión','en revision','revision','revisión'])) $badgeClass = '';
              elseif ($estado_raw === 'pendiente') $badgeClass = '';
            ?>

            <tr>
              <td><?= htmlspecialchars($r['tipo']) ?></td>
              <td><?= htmlspecialchars($r['Fecha_ini']) ?></td>
              <td><?= htmlspecialchars($r['Fecha_fin']) ?></td>
              <td title="<?= htmlspecialchars($r['asunto']) ?>">
                <?= htmlspecialchars($r['asunto']) ?>
              </td>
              <td title="<?= htmlspecialchars($r['motivo']) ?>">
                <?= htmlspecialchars($r['motivo']) ?>
              </td>
              <td>
                <span>
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
