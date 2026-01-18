<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'lib/conexion.php';

$accion = $_GET['accion'] ?? '';
$id_editar = $_GET['id'] ?? null;

/* GUARDAR / EDITAR */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo   = $_POST['titulo'];
    $resumen  = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $id_cate  = $_POST['id_cate'];

    $id_usuario = 1;
    $id_estado  = 1;
    $fecha      = date('Y-m-d H:i:s');

    if (!empty($_POST['id_noticia'])) {
        $sql = "UPDATE noticias SET
                    titulo = ?,
                    resumen = ?,
                    contenido = ?,
                    id_cate = ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id_noticia = ?";
        $pdo->prepare($sql)->execute([
            $titulo, $resumen, $contenido, $id_cate, $_POST['id_noticia']
        ]);
    } else {
        $sql = "INSERT INTO noticias
                (titulo, resumen, contenido, id_usuario, id_cate, id_estado_noticia, fecha_publicacion)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([
            $titulo, $resumen, $contenido, $id_usuario, $id_cate, $id_estado, $fecha
        ]);
    }

    header("Location: noticias-crud.php");
    exit;
}

/* ELIMINAR */
if ($accion === 'eliminar' && $id_editar) {
    $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?")->execute([$id_editar]);
    header("Location: noticias-crud.php");
    exit;
}

/* EDITAR */
$noticia_editar = null;
if ($accion === 'editar' && $id_editar) {
    $stmt = $pdo->prepare("SELECT * FROM noticias WHERE id_noticia = ?");
    $stmt->execute([$id_editar]);
    $noticia_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* CATEGORÍAS */
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);

/* LISTADO */
$noticias = $pdo->query("
    SELECT n.id_noticia, n.titulo, n.fecha_publicacion, c.categorias_noticias
    FROM noticias n
    INNER JOIN categorias c ON n.id_cate = c.id_cate
    ORDER BY n.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias del Barrio</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="assets/css/noticias.css">
</head>
<body>

<div class="container-crud">

    <h2 class="titulo-principal">📰 Noticias del Barrio</h2>

    <!-- FORMULARIO -->
    <div class="card-crud">
        <h5><?= $noticia_editar ? 'Editar noticia' : 'Nueva noticia' ?></h5>

        <form method="POST">
            <input type="hidden" name="id_noticia" value="<?= $noticia_editar['id_noticia'] ?? '' ?>">

            <label>Categoría</label>
            <select name="id_cate" required>
                <option value="">Seleccione</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_cate'] ?>"
                        <?= isset($noticia_editar) && $noticia_editar['id_cate'] == $c['id_cate'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['categorias_noticias']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Título</label>
            <input type="text" name="titulo" required
                   value="<?= $noticia_editar['titulo'] ?? '' ?>">

            <label>Resumen</label>
            <input type="text" name="resumen"
                   value="<?= $noticia_editar['resumen'] ?? '' ?>">

            <label>Contenido</label>
            <textarea name="contenido" rows="4" required><?= $noticia_editar['contenido'] ?? '' ?></textarea>

            <button class="btn-guardar">💾 Guardar</button>
            <?php if ($noticia_editar): ?>
                <a href="noticias-crud.php" class="btn-cancelar">Cancelar</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- LISTADO -->
    <div class="tabla-wrapper">
        <table class="tabla-noticias">
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
                    <td><?= date('d-m-Y', strtotime($n['fecha_publicacion'])) ?></td>
                    <td class="acciones">
                        <a class="btn-editar" href="?accion=editar&id=<?= $n['id_noticia'] ?>">Editar</a>
                        <a class="btn-eliminar" href="?accion=eliminar&id=<?= $n['id_noticia'] ?>"
                           onclick="return confirm('¿Eliminar noticia?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
