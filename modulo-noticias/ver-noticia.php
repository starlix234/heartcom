<?php include("../lib/listar-noticia.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noticias</title>

  <!-- TU CSS -->
  <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">
</head>
<body>

<div class="wrap">
  <div class="card">
    <div class="card-header">
      <h2>Noticias</h2>
    </div>

    <?php if (empty($noticias)): ?>
      <div class="empty-state">
        No hay noticias registradas todavía.
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="tabla-dashboard">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Categoría</th>
              <th>Fecha</th>
              <th style="width: 180px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($noticias as $n): ?>
            <tr>
              <td><?= (int)$n['id_noticia'] ?></td>
              <td>
                <div class="td-title"><?= htmlspecialchars($n['titulo']) ?></div>
                <?php if (!empty($n['bajada'])): ?>
                  <div class="td-sub"><?= htmlspecialchars($n['bajada']) ?></div>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($n['categorias_noticias']) ?></td>
              <td><?= htmlspecialchars($n['fecha_publicacion']) ?></td>
              <td>
                <div class="actions">
                 <a class="btn btn-warning"
                 href="editar-noticia-detalle.php?id=<?= (int)$n['id_noticia'] ?>">
                  Editar
                  </a>
                  <form class="inline"
                        action="../lib/eliminar-noticia.php"
                        method="POST"
                        onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia? Esta acción no se puede deshacer.');">
                    <input type="hidden" name="id" value="<?= (int)$n['id_noticia'] ?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
