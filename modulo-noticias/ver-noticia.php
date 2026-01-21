<?php
include("../lib/listar-noticia.php");
$noticias = $listaNoticias ?? [];
?>

<?php if (empty($noticias)): ?>
  <p>No hay noticias registradas todavía.</p>
<?php else: ?>

<table class="tabla-noticias" cellpadding="8" cellspacing="0">
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
        <td><?= htmlspecialchars($n['titulo'] ?? '') ?></td>
        <td><?= htmlspecialchars($n['categoria'] ?? 'Sin categoría') ?></td>
        <td><?= htmlspecialchars($n['fecha_publicacion'] ?? '') ?></td>
        <td class="centrar">
          <a class="boton" href="editar-noticia-detalle.php?id=<?= (int)($n['id_noticia'] ?? 0) ?>">
            Editar
          </a>

          <form action="../lib/eliminar-noticia.php"
                method="POST"
                onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia?');"
                style="display:inline;">
            <input type="hidden" name="id" value="<?= (int)($n['id_noticia'] ?? 0) ?>">
            <button type="submit" class="boton">Eliminar</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php endif; ?>
