<?php include ("../lib/lista-solicitud-usuario.php")?>
<!DOCTYPE html>
<html lang="en">
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

                <?php if ((int)$sol['id_certi'] === 1 && $sol['monto'] !== null): ?>
                    <p><strong>Monto:</strong> <?= htmlspecialchars($sol['monto']) ?></p>
                <?php endif; ?>

                <?php
                    $esResidencia   = ((int)$sol['id_certi'] === 1);
                    $estaPagado     = ($sol['estado_pago'] ?? '') === 'pagado';
                    $puedePagar     = (int)$sol['puede_pagar'] === 1;
                    $estaAprobada   = ($sol['estado_solicitud'] ?? '') === 'aprobado';
                ?>

                <?php if ($esResidencia): ?>

                    <?php if ($estaPagado): ?>
                        <!-- Residencia pagada: descarga PDF especial -->
                        <a href="../lib/descargar-certificado-residencia.php?id_certificado=<?= (int)$sol['id_certificado'] ?>">
                            Descargar certificado
                        </a>
                    <?php elseif ($puedePagar): ?>
                        <!-- Residencia no pagada pero puede pagar -->
                        <form action="../lib/iniciar-pago.php" method="post">
                            <input type="hidden" name="id_certificado" value="<?= (int)$sol['id_certificado'] ?>">
                            <button type="submit">Pagar</button>
                        </form>
                    <?php endif; ?>

                <?php else: ?>
                    <?php if ($estaAprobada): ?>
                        <!-- Otros certificados aprobados: descarga genérica -->
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
