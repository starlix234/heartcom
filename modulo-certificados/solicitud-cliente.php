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

                <?php if ((int)$sol['puede_pagar'] === 1): ?>
                    <form action="pagar.php" method="post">
                        <input type="hidden" name="id_certificado" value="<?= (int)$sol['id_certificado'] ?>">
                        <button type="submit">Pagar</button>
                    </form>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


    
</body>
</html>