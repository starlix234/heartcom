<?php
require_once '../lib/conexion.php';

// categorias
$stmt = $pdo->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h3>📝 Nueva Noticia</h3>

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
</div>
