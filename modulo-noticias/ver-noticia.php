<?php
session_start();
require_once '../lib/conexion.php';
// require_once '../lib/permisos-admin.php';

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../login.php");
  exit;
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

$sql = "
  SELECT 
    n.id_noticia,
    n.titulo,
    n.bajada,
    n.imagen,
    n.fecha_publicacion,
    n.id_cate,
    c.categorias_noticias,
    n.id_usuario,
    CONCAT_WS(' ', u.p_nombre, u.ap_paterno) AS nombre
  FROM noticias n
  INNER JOIN categorias c ON n.id_cate = c.id_cate
  INNER JOIN usuarios u ON n.id_usuario = u.id_usuario
  ORDER BY n.fecha_publicacion DESC, n.id_noticia DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel de Noticias</title>

  <link rel="stylesheet" href="../assets/css/estilo-dashboard-formulario.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    .toolbar{
      display:flex; gap:12px; align-items:center; justify-content:space-between;
      margin: 10px 0 18px;
      flex-wrap: wrap;
    }
    .toolbar .left{ display:flex; gap:12px; align-items:center; flex-wrap: wrap;}

    .search{
      min-width: 260px;
      padding: 10px 12px;
      border:1px solid #E5E7EB;
      border-radius: 12px;
      outline: none;
      background:#fff;
    }

    .table-wrap{
      width:100%;
      overflow-x: auto;       /* mantiene scroll si hace falta */
      overflow-y: hidden;
      border:1px solid #E5E7EB;
      border-radius: 14px;
      background:#fff;

      /* ✅ OCULTAR BARRA (sin perder el scroll) */
      -ms-overflow-style: none;  /* IE/Edge antiguo */
      scrollbar-width: none;     /* Firefox */
    }
    .table-wrap::-webkit-scrollbar{
      display: none;             /* Chrome/Safari */
    }

    table{
      width:100%;
      border-collapse: collapse;
      min-width: 980px;          /* puedes bajar a 900 si quieres */
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }
    th, td{
      padding: 12px 14px;
      border-bottom: 1px solid #E5E7EB;
      vertical-align: middle;
      font-size: 14px;
      color:#111827;
      white-space: nowrap;
    }
    th{
      background:#F8FAFC;
      font-weight: 700;
      text-align: left;
      position: sticky;
      top: 0;
      z-index: 1;
    }
    td.wrap{
      white-space: normal;
      max-width: 420px;
    }
    .pill{
      display:inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      background: #EEF2FF;
      color:#1E3A8A;
      font-weight:600;
      font-size: 12px;
    }
    .thumb{
      width:56px; height:40px; object-fit: cover; border-radius: 10px;
      border: 1px solid #E5E7EB;
      background:#F3F4F6;
    }
    .actions{
      display:flex; gap:8px; align-items:center;
    }
    .btn-mini{
      display:inline-block;
      padding: 8px 10px;
      border-radius: 12px;
      border: 1px solid #E5E7EB;
      background: #fff;
      text-decoration:none;
      font-weight:700;
      font-size: 13px;
      cursor:pointer;
    }
    .btn-mini:hover{ filter: brightness(0.98); }
    .btn-edit{ border-color:#BFDBFE; background:#EFF6FF; }
    .btn-del{ border-color:#FECACA; background:#FEF2F2; color:#991B1B; }

    .alert{
      padding: 12px 14px;
      border-radius: 14px;
      border: 1px solid #E5E7EB;
      background: #F8FAFC;
      margin: 10px 0 16px;
      color:#111827;
    }
    .muted{ color:#6B7280; font-size: 13px; }
  </style>
</head>

<body>
  <div class="page">
    <div class="card">
      <div class="card-header">
        <h2>📰 Panel de administración de noticias</h2>
        <p class="muted">Edita, elimina y mantén la comunidad al día (sin drama… o con, pero ordenado).</p>
      </div>

      <div style="padding: 18px 20px;">
        <?php if ($msg === 'eliminada'): ?>
          <div class="alert">✅ Noticia eliminada correctamente.</div>
        <?php elseif ($msg === 'error'): ?>
          <div class="alert">⚠️ Ocurrió un problema.</div>
        <?php endif; ?>

        <div class="toolbar">
          <div class="left">
            <a class="btn-mini btn-edit" href="agregar-noticia.php">➕ Nueva noticia</a>
            <input id="search" class="search" type="search" placeholder="Buscar por título, categoría o autor…">
          </div>
          <div class="muted">
            Total: <b><?= count($noticias) ?></b>
          </div>
        </div>

        <div class="table-wrap">
          <table id="tablaNoticias">
            <thead>
              <tr>
                <th style="width:70px;">ID</th>
                <th style="width:110px;">Imagen</th>
                <th>Título</th>
                <th style="width:180px;">Categoría</th>
                <th style="width:180px;">Autor</th>
                <th style="width:170px;">Publicado</th>
                <th style="width:210px; text-align:right;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($noticias)): ?>
                <tr>
                  <td colspan="7" class="wrap">No hay noticias publicadas todavía.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($noticias as $n): ?>
                  <tr>
                    <td><?= (int)$n['id_noticia'] ?></td>

                    <td>
                      <?php if (!empty($n['imagen'])): ?>
                        <img class="thumb" src="../<?= htmlspecialchars($n['imagen']) ?>" alt="imagen">
                      <?php else: ?>
                        <div class="thumb"></div>
                      <?php endif; ?>
                    </td>

                    <td class="wrap">
                      <div style="font-weight:800;"><?= htmlspecialchars($n['titulo']) ?></div>
                      <?php if (!empty($n['bajada'])): ?>
                        <div class="muted"><?= htmlspecialchars($n['bajada']) ?></div>
                      <?php endif; ?>
                    </td>

                    <td><span class="pill"><?= htmlspecialchars($n['categorias_noticias']) ?></span></td>

                    <td><?= htmlspecialchars($n['nombre']) ?></td>

                    <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($n['fecha_publicacion']))) ?></td>

                    <td style="text-align:right;">
                      <div class="actions" style="justify-content:flex-end;">
                        <a class="btn-mini btn-edit" href="editar-noticia.php?id=<?= (int)$n['id_noticia'] ?>">
                          ✏️ Editar
                        </a>

                        <form action="../lib/eliminar_noticia.php" method="POST" style="display:inline;">
                          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                          <input type="hidden" name="id_noticia" value="<?= (int)$n['id_noticia'] ?>">
                          <button
                            type="submit"
                            class="btn-mini btn-del"
                            onclick="return confirm('¿Eliminar esta noticia? Esta acción no se puede deshacer.')"
                          >
                            🗑️ Eliminar
                          </button>
                        </form>
                      </div>
                    </td>

                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>

  <script>
    // Buscador simple (filtra filas)
    const input = document.getElementById('search');
    const table = document.getElementById('tablaNoticias');

    input.addEventListener('input', () => {
      const q = input.value.toLowerCase().trim();
      const rows = table.querySelectorAll('tbody tr');
      rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
