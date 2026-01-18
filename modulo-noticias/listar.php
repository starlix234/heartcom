<?php
require_once '../lib/conexion.php';

$sql = "SELECT 
            n.id_noticia,
            n.titulo,
            n.fecha_publicacion,
            c.categorias_noticias
        FROM noticias n
        INNER JOIN categorias c ON n.id_cate = c.id_cate
        ORDER BY n.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
