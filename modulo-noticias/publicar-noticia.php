<?php 
include("../lib/categoria-noticia.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Noticia</title>
    <link rel="stylesheet" href="../assets/css/estilo-dashboard-formulario.css">
    <script src="../assets/js/validar-largo-texto.js"></script>
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

        <form action="../lib/guardar-noticia.php" method="POST" onsubmit="return valinotic();" enctype="multipart/form-data">

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
            <input type="text" name="titulo" id="noticia" class="control" oninput="validarLargoTexto('noticia',10,200,'erro_noticia')" placeholder="Ej: Nueva plaza inaugurada" required>
            <small id="erro_noticia" style="color:red;"></small>

            <label class="label">Resumen corto (Bajada)</label>
            <input type="text" id="descrip_corta" name="bajada" class="control" oninput="validarLargoTexto('descrip_corta',25,255,'erro_descrip_corta')" placeholder="Breve descripción" required>
            <small id="erro_descrip_corta" style="color:red;"></small>

            <label class="label">Imagen Principal</label>
            <!-- IMPORTANTE: name="foto" para que coincida con guardar_noticia.php -->
            <input type="file" name="foto" class="control" accept="image/*">

            <label class="label">Contenido Completo</label>
            <textarea name="cuerpo" id="contenido" class="control control--textarea" oninput="validarLargoTexto('contenido',100,500,'erro_contenido')" placeholder="Escribe aquí todo el detalle..." required></textarea>
            <small id="erro_contenido" style="color:red;"></small>

            <div class="btn-group" style="margin-top:40px;padding:20px;">
                <button type="submit" class="btn">Publicar Noticia</button><br><br><br>
                <a href="../ver-noticia.php" class="btn btn-cancel" style="margin-top:40px;text-align:center; text-decoration:none; background:#eee; color:#333;">Cancelar</a>

            </div>

        </form>
    </div>
</div>
    <script>
        function valinotic(){
            if(
            !validarLargoTexto('noticia',10,200,'erro_noticia')||
            !validarLargoTexto('descrip_corta',25,255,'error_des')||
            !validarLargoTexto('contenido',100,500,'erro_contenido')
            ){
            return false;
            }
            return true;
        }
    </script>      
</body>
</html>
