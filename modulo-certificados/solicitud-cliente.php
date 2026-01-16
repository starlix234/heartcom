<?php  include ("../lib/lista-solicitud-usuario.php");  ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/estilo-solicitud-cliente.dashboard.css">
  <title>Mis Solicitudes</title>  <!-- Íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>

<body>
  <div class="wrap">
    <div class="card">
      <div class="card-header">
        <div>
          <h2>Mis solicitudes</h2>
          <p>Revisa el estado, paga si corresponde y descarga tus documentos.</p>
        </div>
      </div>

      <?php if (empty($solicitudes)): ?>
        <div class="empty">No tienes solicitudes registradas aún.</div>
      <?php else: ?>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Certificado</th>
                <th>Asunto</th>
                <th>Estado</th>
                <th>Pago</th>
                <th>Monto</th>
                <th>Acciones</th>
              </tr>
            </thead>

            <tbody>
            <?php foreach ($solicitudes as $sol): ?>
              <?php
                $id = (int)($sol['id_certificado'] ?? 0);
                $idFmt = 'CERT-' . str_pad((string)$id, 3, '0', STR_PAD_LEFT);

                $esResidencia = ((int)($sol['id_certi'] ?? 0) === 1);
                $estadoSolRaw = strtolower(trim($sol['estado_solicitud'] ?? 'pendiente'));
                $estadoPagoRaw = strtolower(trim($sol['estado_pago'] ?? 'no aplica'));

                $estaPagado   = ($estadoPagoRaw === 'pagado');
                $puedePagar   = (int)($sol['puede_pagar'] ?? 0) === 1;
                $estaAprobada = ($estadoSolRaw === 'aprobado');

                // Badge estado solicitud
                $bSolClass = 'b-pendiente';
                $bSolText  = 'Pendiente';
                if (str_contains($estadoSolRaw, 'revis')) { $bSolClass='b-revision'; $bSolText='En Revisión'; }
                elseif (str_contains($estadoSolRaw, 'aprob')) { $bSolClass='b-aprobado'; $bSolText='Aprobado'; }
                elseif (str_contains($estadoSolRaw, 'rech')) { $bSolClass='b-rechazado'; $bSolText='Rechazado'; }

                // Badge estado pago
                $bPagoClass = 'b-pago-na';
                $bPagoText  = 'No aplica';
                if ($esResidencia){
                  if ($estaPagado){ $bPagoClass='b-pago-ok'; $bPagoText='Pagado'; }
                  elseif ($puedePagar && $estaAprobada){ $bPagoClass='b-pago-pend'; $bPagoText='Pendiente'; }
                  else { $bPagoClass='b-pago-na'; $bPagoText='No disponible'; }
                }

                $monto = $sol['monto'] ?? null;
                $montoFmt = ($monto !== null) ? number_format((float)$monto, 0, ',', '.') : '—';
              ?>

              <tr>
                <td class="id-code"><?= htmlspecialchars($idFmt) ?></td>

                <td class="type" title="<?= htmlspecialchars($sol['nombre_certificado'] ?? '') ?>">
                  <?= htmlspecialchars($sol['nombre_certificado'] ?? '—') ?>
                </td>

                <td class="asunto" title="<?= htmlspecialchars($sol['asunto'] ?? '') ?>">
                  <?= htmlspecialchars($sol['asunto'] ?? '—') ?>
                </td>

                <td>
                  <span class="badge <?= $bSolClass ?>"><?= htmlspecialchars($bSolText) ?></span>
                </td>

                <td>
                  <span class="badge <?= $bPagoClass ?>"><?= htmlspecialchars($bPagoText) ?></span>
                </td>

                <td class="money">
                  <?php if ($esResidencia && $monto !== null): ?>
                    $ <?= htmlspecialchars($montoFmt) ?>
                  <?php else: ?>
                    —
                  <?php endif; ?>
                </td>

                <td>
                  <div class="actions">

                    <!-- ACCIONES PARA RESIDENCIA -->
                    <?php if ($esResidencia): ?>

                      <?php if ($estaPagado): ?>
                        <!-- Descargar certificado residencia -->
                        <a class="icon-btn icon-download"
                           href="../lib/descargar-certificado-residencia.php?id_certificado=<?= $id ?>"
                           title="Descargar certificado">
                          <i class="fa-solid fa-download"></i>
                        </a>

                        <!-- Descargar boleta -->
                        <a class="icon-btn icon-receipt"
                           href="../lib/emitir-boleta-certificado.php?id_certificado=<?= $id ?>"
                           title="Descargar boleta de pago">
                          <i class="fa-regular fa-file-lines"></i>
                        </a>

                      <?php elseif ($puedePagar && $estaAprobada): ?>
                        <!-- Botón pagar (form para POST) -->
                        <form action="/lib/iniciar-pago.php" method="post" style="display:inline;">
                          <input type="hidden" name="id_certificado" value="<?= $id ?>">
                          <button class="icon-btn icon-pay"
                                  type="submit"
                                  title="Pagar"
                                  onclick="return confirm('¿Iniciar pago de este certificado?');">
                            <i class="fa-solid fa-credit-card"></i>
                          </button>
                        </form>

                      <?php else: ?>
                        <!-- Nada disponible aún -->
                        <span class="icon-btn icon-disabled" title="Acción no disponible">
                          <i class="fa-solid fa-ban"></i>
                        </span>
                      <?php endif; ?>

                    <!-- ACCIONES PARA OTROS CERTIFICADOS -->
                    <?php else: ?>

                      <?php if ($estaAprobada): ?>
                        <a class="icon-btn icon-download"
                           href="../lib/descargar-certificado.php?id_certificado=<?= $id ?>"
                           title="Descargar certificado">
                          <i class="fa-solid fa-download"></i>
                        </a>
                      <?php else: ?>
                        <span class="icon-btn icon-disabled" title="Disponible cuando esté aprobado">
                          <i class="fa-solid fa-clock"></i>
                        </span>
                      <?php endif; ?>

                    <?php endif; ?>

                  </div>
                </td>
              </tr>

            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php endif; ?>
    </div>
  </div>
</body>
</html>
