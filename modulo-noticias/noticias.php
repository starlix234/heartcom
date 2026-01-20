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

<div class="container mt-4">

    <h2>📰 Noticias del Barrio</h2>

    <!-- ENLACE CREATE -->
    <a href="crear.php" class="btn btn-primary mb-3">
        + Nueva Noticia
    </a>

    <!-- LISTADO -->
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
                <td>
                    <?= $n['fecha_publicacion']
                        ? date('d-m-Y', strtotime($n['fecha_publicacion']))
                        : '-' ?>
                </td>
                <td>
                    <!-- EDITAR -->
                    <a href="editar.php?id=<?= $n['id_noticia'] ?>"
                       class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <!-- ELIMINAR -->
                    <form action="eliminar.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?= $n['id_noticia'] ?>">
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Eliminar noticia?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

</body>
</html>
