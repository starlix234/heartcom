
<?php include("../lib/listar-mis-reservas.php")?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis reservas</title>
</head>
<body>
    <h1>Mis reservas</h1>

    <?php if (empty($reservas)): ?>
        <p>No tienes reservas registradas.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Tipo</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Asunto</th>
                <th>Motivo</th>
                <th>Estado</th>
            </tr>

            <?php foreach ($reservas as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['tipo']) ?></td>
                    <td><?= htmlspecialchars($r['Fecha_ini']) ?></td>
                    <td><?= htmlspecialchars($r['Fecha_fin']) ?></td>
                    <td><?= htmlspecialchars($r['asunto']) ?></td>
                    <td><?= htmlspecialchars($r['motivo']) ?></td>
                    <td><?= htmlspecialchars($r['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>