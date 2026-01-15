<?php include("../lib/mostra-proyectos.php");?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
</head>
<body>
    <h1>Proyectos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre del Proyecto</th>
                <th>Descripción</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Responsable</th>
                <th>Cupo Máximo</th>
                <th>Tipo de Proyecto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $proyecto): ?>
            <tr>
                <td><?php echo htmlspecialchars($proyecto['nombre_proyecto']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['fecha_fin']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['responsable']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['cupo_maximo']); ?></td>
                <td><?php echo htmlspecialchars($proyecto['nombre_tipo']); ?></td>

            </tr>

            <?php endforeach; ?>
        </tbody>

    </table>

</body>
</html>