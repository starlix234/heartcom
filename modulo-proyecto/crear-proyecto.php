<?php include('../lib/listar-tipo-proyecto.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Proyecto</title>
</head>
<body>

<h1>Panel de Proyectos</h1>

<hr>
<!-- 👇 FORMULARIO ABAJO 👇 -->
<h2>Crear nuevo proyecto</h2>

<form action="../lib/guardar-proyecto.php" method="POST">

    <label>Nombre del proyecto</label><br>
    <input type="text" name="nombre_proyecto" required><br><br>

    <label>Descripción</label><br>
    <textarea name="descripcion" required></textarea><br><br>

    <label>Fecha inicio</label><br>
    <input type="date" name="fecha_inicio" required><br><br>

    <label>Fecha fin</label><br>
    <input type="date" name="fecha_fin"><br><br>

    <label>Tipo de proyecto</label><br>
    <select name="id_tipo_proyecto" required>
        <option value="">Seleccione tipo</option>
        <?php foreach ($tipos as $t): ?>
            <option value="<?= $t['id_tipo_proyecto'] ?>">
                <?= htmlspecialchars($t['nombre_tipo']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>


    <label>Presupuesto estimado</label><br>
    <input type="number" name="presupuesto_estimado" value="0"><br><br>

    <label>Dirección del proyecto</label><br>
    <input type="text" name="direccion_proyecto"><br><br>

    <label>Cupo máximo</label><br>
    <input type="number" name="cupo_maximo" value="0"><br><br>

    <button type="submit" name="guardar">Guardar proyecto</button>

</form>

</body>
</html>


