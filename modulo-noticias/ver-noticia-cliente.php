<?php
// ✅ include inteligente: funciona si entras directo al módulo o si lo incluyes desde index.php

$archivo = 'lib/listar-noticia.php';

// 1) Ruta relativa desde ESTE archivo (módulo): /modulo-noticias/../lib/...
$rutaModulo = __DIR__ . '/../' . $archivo;

// 2) Ruta "directa" desde la raíz del sitio (DOCUMENT_ROOT):
// En XAMPP suele ser C:\xampp\htdocs  -> quedará tipo C:\xampp\htdocs\heartcom\lib\...
$baseUrlProyecto = 'heartcom'; // 👈 si tu carpeta se llama distinto, cámbiala
$rutaDirecta = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . DIRECTORY_SEPARATOR
             . $baseUrlProyecto . DIRECTORY_SEPARATOR
             . str_replace('/', DIRECTORY_SEPARATOR, $archivo);

// Elegimos la que exista
if (file_exists($rutaModulo)) {
    require_once $rutaModulo;
} elseif (file_exists($rutaDirecta)) {
    require_once $rutaDirecta;
} else {
    die("No se encontró el include requerido. Probé: <br>"
      . htmlspecialchars($rutaModulo) . "<br>"
      . htmlspecialchars($rutaDirecta));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Noticias</title>

  <style>
    :root{
      --text:#111827;
      --muted:#6B7280;
      --line:#E5E7EB;
      --bg:#F8FAFC;
      --card:#ffffff;
      --shadow: 0 10px 30px rgba(0,0,0,.06);
      --radius:18px;

      --badgeText:#2563EB;
      --badgeBg:#EFF6FF;
      --badgeLine:#DBEAFE;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    .wrap{
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 16px;
    }

    .header{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:12px;
      margin-bottom: 16px;
    }

    .header h2{
      margin:0;
      font-size: 1.6rem;
      font-weight: 900;
      letter-spacing: -.02em;
    }

    .header p{
      margin: 6px 0 0;
      color: var(--muted);
    }

    .grid{
      display:grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px;
    }

    @media (max-width: 980px){
      .grid{ grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px){
      .grid{ grid-template-columns: 1fr; }
    }

    .card{
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow);
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .card:hover{
      transform: translateY(-2px);
      box-shadow: 0 14px 40px rgba(0,0,0,.10);
    }

    /* Imagen/placeholder arriba (porque tu SELECT no trae imagen) */
    .media{
      padding: 10px;
      background: transparent;
    }
    .media .ph{
      height: 170px;
      border-radius: 14px;
      border: 1px solid var(--line);
      background: #F3F4F6;
      display:flex;
      align-items:center;
      justify-content:center;
      color: #9CA3AF;
      font-weight: 700;
    }

    .body{
      padding: 8px 16px 18px;
    }

    .top{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin: 4px 0 12px;
    }

    .badge{
      display:inline-flex;
      align-items:center;
      padding: 6px 12px;
      border-radius: 999px;
      font-size: .85rem;
      font-weight: 600;
      color: var(--badgeText);
      background: var(--badgeBg);
      border: 1px solid var(--badgeLine);
      white-space: nowrap;
    }

    .date{
      font-size: .85rem;
      color: var(--muted);
      white-space: nowrap;
    }

    .title{
      margin: 0 0 8px;
      font-size: 1.15rem;
      line-height: 1.25;
      font-weight: 900;
      letter-spacing: -.01em;
    }

    .title a{
      color: var(--text);
      text-decoration:none;
    }
    .title a:hover{
      text-decoration: underline;
      text-underline-offset: 3px;
    }

    .text{
      margin: 0 0 14px;
      color: var(--muted);
      line-height: 1.55;
      font-size: .95rem;

      display:-webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow:hidden;
      min-height: 3.2em;
    }

    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding: 10px 12px;
      border-radius: 12px;
      background: #111827;
      color:#fff;
      text-decoration:none;
      font-weight: 800;
      border:1px solid #111827;
    }

    .empty{
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      padding: 16px;
      color: var(--muted);
      box-shadow: var(--shadow);
    }
  </style>
</head>
<body>

<div class="wrap">
  <div class="header">
    <div>
      <h2>Noticias</h2>
    </div>
  </div>

  <?php if (empty($noticias)): ?>
    <div class="empty">Aún no hay noticias publicadas.</div>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($noticias as $n): ?>
        <?php
          $fecha = date("d M Y", strtotime($n['fecha_publicacion']));
          $bajada = $n['bajada'] ?? '';
          if ($bajada === '') $bajada = "Sin resumen disponible.";
        ?>
        <article class="card">
          <div class="media">
            <div class="ph">Imagen</div>
          </div>

          <div class="body">
            <div class="top">
              <span class="badge"><?= htmlspecialchars($n['categorias_noticias']) ?></span>
              <span class="date"><?= htmlspecialchars($fecha) ?></span>
            </div>

            <h3 class="title">
              <a href="noticia.php?id=<?= (int)$n['id_noticia'] ?>">
                <?= htmlspecialchars($n['titulo']) ?>
              </a>
            </h3>

            <p class="text"><?= htmlspecialchars($bajada) ?></p>

            <a class="btn" href="modulo-noticias/noticia-detalle-cliente.php?id=<?= (int)$n['id_noticia'] ?>">Ver noticia</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>

</body>
</html>