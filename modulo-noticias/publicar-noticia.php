<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// SOLO LISTAR
require_once '../lib/mostrar-noticia.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias del Barrio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<form action="guardar.php" method="POST">

        <div class="mb-3">
            <label>Categoría</label>
            <select name="id_cate" class="form-control" required>
                <option value="">Seleccione</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_cate'] ?>">
                        <?= htmlspecialchars($c['categorias_noticias']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Resumen</label>
            <input type="text" name="resumen" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contenido</label>
            <textarea name="contenido" class="form-control" rows="6" required></textarea>
        </div>

        <div class="mb-3">
            <label>Fecha de publicación</label>
            <input type="datetime-local" name="fecha_publicacion" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
