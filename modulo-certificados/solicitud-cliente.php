<?php  include ("../lib/lista-solicitud-usuario.php");  ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>
</head>
<body>
<div class="mis-solicitudes">
    <?php if (empty($solicitudes)): ?>
        <p>No tienes solicitudes registradas aún.</p>
    <?php else: ?>
        <?php foreach ($solicitudes as $sol): ?>
            <div class="solicitud-card">
                <p><strong>ID:</strong> <?= htmlspecialchars($sol['id_certificado']) ?></p>
                <p><strong>Certificado:</strong> <?= htmlspecialchars($sol['nombre_certificado']) ?></p>
                <p><strong>Asunto:</strong> <?= htmlspecialchars($sol['asunto']) ?></p>
                <p><strong>Estado Solicitud:</strong> <?= htmlspecialchars($sol['estado_solicitud']) ?></p>
                <p><strong>Estado Pago:</strong> <?= htmlspecialchars($sol['estado_pago'] ?? 'No aplica') ?></p>

                <?php
                    $esResidencia   = ((int)$sol['id_certi'] === 1);
                    $estaPagado     = strtolower($sol['estado_pago'] ?? '') === 'pagado';
                    $puedePagar     = (int)($sol['puede_pagar'] ?? 0) === 1;
                    $estaAprobada   = strtolower($sol['estado_solicitud'] ?? '') === 'aprobado';
                ?>

                <?php if ($esResidencia): ?>

                    <?php if ($sol['monto'] !== null): ?>
                        <p><strong>Monto:</strong> <?= htmlspecialchars(number_format($sol['monto'], 0, ',', '.')) ?></p>
                    <?php endif; ?>

                    <?php if ($estaPagado): ?>
                        <!-- Residencia pagada: descarga certificado + boleta WebPay -->
                        <a href="../lib/descargar-certificado-residencia.php?id_certificado=<?= (int)$sol['id_certificado'] ?>">
                            Descargar certificado
                        </a>
                        <br>
                        <a href="../lib/emitir-boleta-certificado.php?id_certificado=<?= (int)$sol['id_certificado'] ?>">
                            Descargar boleta de pago
                        </a>

                    <?php elseif ($puedePagar && $estaAprobada): ?>
                        <form action="/lib/iniciar-pago.php" method="post">
                            <input type="hidden" name="id_certificado" value="<?= (int)$sol['id_certificado'] ?>">
                            <button type="submit">Pagar</button>
                        </form>
                    <?php endif; ?>

                <?php else: ?>
                    <?php if ($estaAprobada): ?>
                        <a href="../lib/descargar-certificado.php?id_certificado=<?= (int)$sol['id_certificado'] ?>">
                            Descargar certificado
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
