<?php include("../lib/mostrar-noticia.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-4">
    <h3>📰 Noticias del Barrio</h3>

    <a href="crear.php" class="btn btn-primary mb-3">+ Nueva Noticia</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($noticias as $n): ?>
            <tr>
                <td><?= htmlspecialchars($n['titulo']) ?></td>
                <td><?= htmlspecialchars($n['categorias_noticias']) ?></td>
                <td><?= $n['fecha_publicacion'] ? date('d-m-Y', strtotime($n['fecha_publicacion'])) : '-' ?></td>
                <td>
                    <a href="eliminar.php?id=<?= $n['id_noticia'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar noticia?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

