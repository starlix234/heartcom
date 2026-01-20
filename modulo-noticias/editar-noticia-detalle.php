
<?php include("../lib/listar-edicion-noticia.php")?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar noticia</title>

  <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">

  <style>
    .grid-2{display:grid; grid-template-columns: 340px 1fr; gap:18px;}
    @media (max-width: 900px){ .grid-2{grid-template-columns: 1fr;} }
    .panel{border:1px solid var(--line,#E5E7EB); border-radius:14px; background:#fff; padding:16px;}
    .img-preview{width:100%; height:220px; object-fit:cover; border-radius:14px; border:1px solid var(--line,#E5E7EB);}
    .muted{color:#6B7280; font-size:.9rem;}
    .form-row{display:grid; grid-template-columns: 1fr 1fr; gap:12px;}
    @media (max-width: 900px){ .form-row{grid-template-columns: 1fr;} }
    label{display:block; font-weight:600; margin:10px 0 6px;}
    input[type="text"], input[type="date"], select, textarea{
      width:100%; padding:10px 12px; border-radius:12px; border:1px solid var(--line,#E5E7EB);
      outline:none;
    }
    textarea{min-height:170px; resize:vertical;}
    .btn-row{display:flex; gap:10px; flex-wrap:wrap; margin-top:14px;}
    .badge-muted{display:inline-block; padding:6px 10px; border-radius:999px; background:#F3F4F6; color:#6B7280; font-size:.85rem;}
  </style>
</head>
<body>

<div class="wrap">
  <div class="card">
    <div class="card-header">
      <h2>Editar noticia</h2>
      <a class="btn btn-secondary" href="noticias.php">Volver</a>
    </div>

    <div style="padding:18px;">
      <?php if ($ok === 'saved'): ?>
        <div class="empty-state" style="background:#ECFDF5; border:1px solid #A7F3D0; color:#065F46;">
          Cambios guardados ✅
        </div>
      <?php endif; ?>

      <?php if ($err): ?>
        <div class="empty-state" style="background:#FEF2F2; border:1px solid #FECACA; color:#991B1B;">
          Error: <?= htmlspecialchars($err) ?>
        </div>
      <?php endif; ?>

      <div class="grid-2">

        <!-- PREVIEW -->
        <div class="panel">
          <h3 style="margin:0 0 10px;">Vista previa</h3>

          <?php if (!empty($noticia['imagen'])): ?>
            <img src="../<?= htmlspecialchars($noticia['imagen']) ?>" class="img-preview" alt="Imagen noticia">
          <?php else: ?>
            <div class="badge-muted">Sin imagen</div>
          <?php endif; ?>

          <p style="margin:12px 0 4px;"><strong><?= htmlspecialchars($noticia['titulo']) ?></strong></p>
          <?php if (!empty($noticia['bajada'])): ?>
            <p class="muted" style="margin:0 0 8px;"><?= htmlspecialchars($noticia['bajada']) ?></p>
          <?php endif; ?>

          <p class="muted" style="margin:0;">
            Fecha: <?= htmlspecialchars($noticia['fecha_publicacion']) ?>
          </p>
        </div>

        <!-- FORM -->
        <div class="panel">
          <h3 style="margin:0 0 10px;">Editar</h3>

          <form action="../lib/editar-noticia.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_noticia" value="<?= (int)$noticia['id_noticia'] ?>">

            <label>Título</label>
            <input type="text" name="titulo" required value="<?= htmlspecialchars($noticia['titulo']) ?>">

            <label>Bajada</label>
            <input type="text" name="bajada" value="<?= htmlspecialchars($noticia['bajada'] ?? '') ?>">

            <div class="form-row">
              <div>
                <label>Categoría</label>
                <select name="id_cate" required>
                  <option value="">Seleccione</option>
                  <?php foreach ($categorias as $c): ?>
                    <option value="<?= (int)$c['id_cate'] ?>"
                      <?= ((int)$noticia['id_cate'] === (int)$c['id_cate']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($c['categorias_noticias']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div>
                <label>Fecha de publicación</label>
                <input type="date" name="fecha_publicacion"
                       value="<?= htmlspecialchars(substr($noticia['fecha_publicacion'], 0, 10)) ?>">
              </div>
            </div>

            <label>Cuerpo</label>
            <textarea name="cuerpo" required><?= htmlspecialchars($noticia['cuerpo'] ?? '') ?></textarea>

            <label>Cambiar imagen (opcional)</label>
            <input type="file" name="imagen" accept="image/png,image/jpeg,image/webp,image/avif">
            <p class="muted" style="margin:6px 0 0;">
              Si no subes nada, se mantiene la imagen actual.
            </p>

            <div class="btn-row">
              <button class="btn btn-primary" type="submit">Guardar cambios</button>
              <a class="btn btn-secondary" href="noticias.php">Cancelar</a>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
