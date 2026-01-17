<?php include("../lib/mostrar-reserva-admin.php")?>

<section class="card card--embed">
  <?php if (isset($_GET['msg'])): ?>
    <div class="msg"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="table-wrap table-wrap--embed">
    <?php if (empty($reservas)): ?>
      <div class="empty">No hay reservas registradas.</div>
    <?php else: ?>
      <table class="table-dashboard">
        <thead>
          <tr>
            <th>Vecino</th>
            <th>Tipo</th>
            <th>Asunto y Motivo</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($reservas as $res): ?>
          <?php
            $estado_raw = trim(mb_strtolower($res['estado'] ?? ''));
            $badgeClass = 'badge-pendiente';

            if (in_array($estado_raw, ['aprobado','aprobada'])) $badgeClass = 'badge-aprobado';
            elseif (in_array($estado_raw, ['rechazado','rechazada'])) $badgeClass = 'badge-rechazado';
            elseif (in_array($estado_raw, ['en revisión','en revision','revision','revisión'])) $badgeClass = 'badge-revision';
            elseif (in_array($estado_raw, ['en proceso','pendiente'])) $badgeClass = 'badge-pendiente';
          ?>

          <tr>
            <td class="name"><?= htmlspecialchars($res['nombre_completo']) ?></td>
            <td class="type"><?= htmlspecialchars($res['tipo']) ?></td>
            <td class="text-clip" title="<?= htmlspecialchars($res['asunto']) ?>">
              <h6><?= htmlspecialchars($res['asunto']) ?></h6>
              <p>
               <?= htmlspecialchars($res['motivo']) ?>
        </p>
            </td>
        
            <td class="date"><?= htmlspecialchars($res['Fecha_ini']) ?></td>
            <td class="date"><?= htmlspecialchars($res['Fecha_fin']) ?></td>

            <td>
              <span class="badge <?= $badgeClass ?>">
                <?= htmlspecialchars($res['estado']) ?>
              </span>
            </td>

            <td>
              <div class="actions">
                <?php if ($estado_raw === 'en proceso' || $estado_raw === 'pendiente'): ?>

                  <form action="../lib/procesar-reserva.php" method="post" class="action-form">
                    <input type="hidden" name="id_reserva" value="<?= (int)$res['id_reserva'] ?>">
                    <input type="hidden" name="accion" value="aprobar">
                    <button class="icon-btn icon-approve" type="submit" title="Aprobar" aria-label="Aprobar">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </button>
                  </form>

                  <form action="../lib/procesar-reserva.php" method="post" class="action-form">
                    <input type="hidden" name="id_reserva" value="<?= (int)$res['id_reserva'] ?>">
                    <input type="hidden" name="accion" value="rechazar">
                    <button class="icon-btn icon-reject" type="submit" title="Rechazar" aria-label="Rechazar">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                      </svg>
                    </button>
                  </form>

                <?php else: ?>
                  <span class="muted-small">Sin acciones</span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</section>

