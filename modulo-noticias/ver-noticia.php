<?php
include("../lib/listar-noticia.php");
$noticias = $listaNoticias ?? [];
?>

<div class="wrap">
  <div class="card">
    <div class="card-header">
      <h2>Noticias</h2>
    </div>

    <?php if (empty($noticias)): ?>
      <div class="empty-state">No hay noticias registradas todavía.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="tabla-dashboard">
          <thead>
            <tr>
              <th style="width:80px;">ID</th>
              <th>Título</th>
              <th style="width:200px;">Categoría</th>
              <th style="width:160px;">Fecha</th>
              <th style="width:220px;">Acciones</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($noticias as $n): ?>
            <tr>
              <td><?= (int)($n['id_noticia'] ?? 0) ?></td>

              <td>
                <div class="td-title"><?= htmlspecialchars($n['titulo'] ?? '') ?></div>
                <?php if (!empty($n['bajada'])): ?>
                  <div class="td-sub"><?= htmlspecialchars($n['bajada']) ?></div>
                <?php endif; ?>
              </td>

              <td><?= htmlspecialchars($n['categoria'] ?? 'Sin categoría') ?></td>
              <td><?= htmlspecialchars($n['fecha_publicacion'] ?? '') ?></td>

              <td>
                <div class="actions">
                  <a class="btn btn-warning"
                     href="editar-noticia-detalle.php?id=<?= (int)($n['id_noticia'] ?? 0) ?>">
                    Editar
                  </a>

                  <form class="inline"
                        action="../lib/eliminar-noticia.php"
                        method="POST"
                        onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia?');">
                    <input type="hidden" name="id" value="<?= (int)($n['id_noticia'] ?? 0) ?>">
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
