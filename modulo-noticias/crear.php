<?php include("../lib/crear-noticia.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS EXTERNO -->
    <link rel="stylesheet" href="../assets/css/crear-noticia.css">
</head>

<body>

<div class="card">

    <!-- Header -->
    <div class="card__header">
        <div class="card__icon">📝</div>
        <div>
            <h2 class="card__title">Crear Noticia</h2>
            <p class="card__subtitle">
                Complete el formulario para publicar una nueva noticia.
            </p>
        </div>
    </div>

    <!-- Formulario -->
    <form action="guardar.php" method="POST" class="form" enctype="multipart/form-data">

        <!-- Categoría -->
        <div class="mb-3">
            <label class="label">Categoría</label>
            <select name="id_cate" class="form-select control" required>
                <option value="">Seleccione</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_cate'] ?>">
                        <?= htmlspecialchars($c['categorias_noticias']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Título -->
        <div class="mb-3">
            <label class="label">Título</label>
            <input type="text" name="titulo" class="form-control control"
                   placeholder="Ingrese el título de la noticia" required>
        </div>

        <!-- Resumen -->
        <div class="mb-3">
            <label class="label">Resumen</label>
            <input type="text" name="resumen" class="form-control control"
                   placeholder="Breve resumen (opcional)">
        </div>

        <!-- Contenido -->
        <div class="mb-3">
            <label class="label">Contenido</label>
            <textarea name="contenido" class="form-control control"
                      placeholder="Desarrolle el contenido de la noticia"
                      required></textarea>
        </div>

        <!-- Fecha y Hora -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="label">Fecha de publicación</label>
                <input type="date" name="fecha_publicacion"
                       class="form-control control" required>
            </div>

            <div class="col-md-6">
                <label class="label">Hora de publicación</label>
                <input type="time" name="hora_publicacion"
                       class="form-control control" required>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between align-items-center mt-4">

            <!-- Volver -->
            <button type="button" class="btn btn-secondary"
                    onclick="history.back()">
                Volver
            </button>

            <!-- Derecha -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('imagen').click()">
                    Insertar imagen
                </button>

                <button type="submit" class="btn btn-success">
                    💾 Guardar
                </button>
            </div>

        </div>

        <!-- Imagen -->
        <input type="file" name="imagen" id="imagen" accept="image/*" hidden>

    </form>

</div>

</body>
</html>
