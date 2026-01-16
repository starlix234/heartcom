<?php include("../lib/mostrar-proyecto-admin.php") ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Proyectos</title>
</head>
<body>
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
                <th>Estado de Proyecto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $pr): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pr['nombre_proyecto']); ?></td>
                    <td><?php echo htmlspecialchars($pr['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($pr['fecha_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($pr['fecha_fin']); ?></td>
                    <td><?php echo htmlspecialchars($pr['responsable']); ?></td>
                    <td><?php echo htmlspecialchars($pr['cupo_maximo']); ?></td>
                    <td><?php echo htmlspecialchars($pr['nombre_tipo']); ?></td>
                    <td><?php echo htmlspecialchars($pr['nombre_estado'])  ?></td>
                    <td>
                        <form action="cambiar-estado-proyecto.php" method="POST">
                            <input type="hidden" name="id_proyecto" value="<?= $pr['id_proyecto'] ?>">
                            <button type="submit">Cambiar estado</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>