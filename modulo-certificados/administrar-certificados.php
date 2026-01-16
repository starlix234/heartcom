<?php include("../lib/listar-certificado.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">
  <title>Solicitudes de Certificados</title>

  <!-- Font Awesome (íconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>

<body>
  <div class="wrap">
    <div class="card">
      <div class="card-header">
        <div>
          <h2>Gestión de solicitudes recientes</h2>
          <p class="muted">Revisa, aprueba o rechaza solicitudes de certificados.</p>
        </div>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Solicitante</th>
              <th>Tipo de Certificado</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($solicitudes as $s): ?>
            <?php
              // ID tipo "CERT-001"
              $idNum = (int)($s['id_certificado'] ?? 0);
              $idFmt = 'CERT-' . str_pad((string)$idNum, 3, '0', STR_PAD_LEFT);

              $nombreCompleto = trim(($s['nombre'] ?? '') . ' ' . ($s['apellido'] ?? ''));
              $tipo = $s['tipo_certificado'] ?? $s['asunto'] ?? 'Certificado';
              $fechaRaw = $s['fecha'] ?? $s['fecha_solicitud'] ?? '';
              $fechaFmt = $fechaRaw ? date('d/m/Y', strtotime($fechaRaw)) : '-';

              $estado = strtolower(trim($s['estado'] ?? 'pendiente'));

              // Mapeo de badge por estado
              $badgeClass = 'badge-pendiente';
              $badgeText  = 'Pendiente';

              if (str_contains($estado, 'revis')) { $badgeClass='badge-revision'; $badgeText='En Revisión'; }
              elseif (str_contains($estado, 'aprob')) { $badgeClass='badge-aprobado'; $badgeText='Aprobado'; }
              elseif (str_contains($estado, 'rech')) { $badgeClass='badge-rechazado'; $badgeText='Rechazado'; }

              $correo = $s['correo'] ?? '';
              $nombre = $s['nombre'] ?? '';
            ?>

            <tr>
              <td class="id-code"><?= htmlspecialchars($idFmt) ?></td>

              <td class="name"><?= htmlspecialchars($nombreCompleto ?: '—') ?></td>

              <td class="type" title="<?= htmlspecialchars($tipo) ?>">
                <?= htmlspecialchars($tipo) ?>
              </td>

              <td class="date"><?= htmlspecialchars($fechaFmt) ?></td>

              <td>
                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($badgeText) ?></span>
              </td>

              <td>
                <div class="actions">

                  <!-- VER (detalle) -->
                  <a class="icon-btn icon-view"
                     href="ver-solicitud.php?id=<?= (int)$idNum ?>"
                     title="Ver solicitud">
                    <i class="fa-regular fa-eye"></i>
                  </a>

                  <!-- Si está pendiente o en revisión: mostrar aprobar/rechazar -->
                  <?php if ($badgeClass === 'badge-pendiente' || $badgeClass === 'badge-revision'): ?>
                    <form method="POST" action="lib/gestionar-solicitud.php" style="display:inline;">
                      <input type="hidden" name="id_certificado" value="<?= (int)$idNum ?>">
                      <input type="hidden" name="correo" value="<?= htmlspecialchars($correo) ?>">
                      <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">

                      <button class="icon-btn icon-approve"
                              type="submit"
                              name="accion"
                              value="aprobar"
                              title="Aprobar"
                              onclick="return confirm('¿Aprobar esta solicitud?');">
                        <i class="fa-solid fa-check"></i>
                      </button>

                      <button class="icon-btn icon-reject"
                              type="submit"
                              name="accion"
                              value="rechazar"
                              title="Rechazar"
                              onclick="return confirm('¿Rechazar esta solicitud?');">
                        <i class="fa-solid fa-xmark"></i>
                      </button>
                    </form>
                  <?php endif; ?>

                  <!-- Si está aprobado: mostrar descargar -->
                  <?php if ($badgeClass === 'badge-aprobado'): ?>
                    <a class="icon-btn icon-download"
                       href="descargar-certificado.php?id=<?= (int)$idNum ?>"
                       title="Descargar">
                      <i class="fa-solid fa-download"></i>
                    </a>
                  <?php endif; ?>

                </div>
              </td>
            </tr>

          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
