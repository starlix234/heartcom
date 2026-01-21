<?php
include("../lib/listar-noticia.php");
$noticias = $listaNoticias;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Noticias</title>
  <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">

  <style>
    /* 🔧 1. CENTRAR EL APARTADO COMPLETO */
    .wrap{
      max-width: 900px;
      width: 100%;
      margin: 40px auto;   /* ✅ CENTRADO REAL */
      padding:  69px;
    }

    /* 🔧 2. SCROLL CONTROLADO */
    .table-responsive{
      width:100%;
      overflow-x:auto;
    }

    /* 🔧 3. TABLA CON ANCHO CONTROLADO */
    .tabla-dashboard{
      width:100%;
      min-width: 900px;
      border-collapse:collapse;
    }

    /* 🔧 4. BOTONES ESTABLES */
    .actions{
      display:flex;
      gap:10px;
      flex-wrap:nowrap;
      white-space:nowrap;
      justify-content:flex-start;
    }
    
  </style>
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
              <td><?= (int)$n['id_noticia'] ?></td>

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
                     href="editar-noticia-detalle.php?id=<?= (int)$n['id_noticia'] ?>">
                    Editar
                  </a>

                  <form class="inline"
                        action="../lib/eliminar-noticia.php"
                        method="POST"
                        onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia?');">
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
