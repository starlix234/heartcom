<?php 
include("../lib/categoria-noticia.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Noticia</title>
    <link rel="stylesheet" href="../assets/css/estilo-dashboard-formulario.css">
    <style>
        input[type="file"] { padding: 10px; background: white; }
    </style>
</head>
<body>

<div class="page">
    <div class="card">
        <div class="card-header">
            <h2>📢 Publicar Nueva Noticia</h2>
            <p>Completa los datos para informar a la comunidad.</p>
        </div>

        <form action="../lib/guardar-noticia.php" method="POST" enctype="multipart/form-data">

            <label class="label">Categoría</label>
            <select name="id_cate" class="control" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= (int)$c['id_cate'] ?>">
                        <?= htmlspecialchars($c['categorias_noticias']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="label">Título de la noticia</label>
            <input type="text" name="titulo" class="control" placeholder="Ej: Nueva plaza inaugurada" required>

            <label class="label">Resumen corto (Bajada)</label>
            <input type="text" name="bajada" class="control" placeholder="Breve descripción" required>

            <label class="label">Imagen Principal</label>
            <!-- IMPORTANTE: name="foto" para que coincida con guardar_noticia.php -->
            <input type="file" name="foto" class="control" accept="image/*">

            <label class="label">Contenido Completo</label>
            <textarea name="cuerpo" class="control control--textarea" placeholder="Escribe aquí todo el detalle..." required></textarea>

            <div class="btn-group" style="margin-top:40px;padding:20px;">
                <button type="submit" class="btn">Publicar Noticia</button><br><br><br>
                <a href="../ver-noticia.php" class="btn btn-cancel" style="margin-top:40px;text-align:center; text-decoration:none; background:#eee; color:#333;">Cancelar</a>

            </div>

        </form>
    </div>
</div>

</body>
</html>
