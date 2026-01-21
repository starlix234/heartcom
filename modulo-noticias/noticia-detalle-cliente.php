<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/heartcom/lib/listar-noticia-cliente-detalle.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($n['titulo']) ?> - HeartCom</title>

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
    *{box-sizing:border-box}

    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:var(--bg);
      color:var(--text);
    }

    .wrap{
      max-width: 980px;
      margin: 34px auto;
      padding: 0 16px;
    }

    .topbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin-bottom: 14px;
    }

    .brand{
      font-weight: 900;
      letter-spacing: -.02em;
    }

    .back{
      display:inline-flex;
      align-items:center;
      gap:8px;
      text-decoration:none;
      font-weight:800;
      color:var(--text);
      padding:10px 12px;
      border-radius: 12px;
      border:1px solid var(--line);
      background: var(--card);
      box-shadow: var(--shadow);
      transition: transform .15s ease;
    }
    .back:hover{ transform: translateY(-1px); }

    .card{
      background:var(--card);
      border:1px solid var(--line);
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow);
    }

    .media{
      padding: 10px;
      background: transparent;
    }
    .media img{
      width:100%;
      height: 280px;
      object-fit: cover;
      border-radius: 14px;
      border:1px solid var(--line);
      display:block;
      background:#F3F4F6;
    }

    .content{
      padding: 10px 18px 20px;
    }

    .meta{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      margin: 6px 0 12px;
    }

    .badge{
      display:inline-flex;
      align-items:center;
      padding: 6px 12px;
      border-radius: 999px;
      font-size: .85rem;
      font-weight: 600;
      color:var(--badgeText);
      background:var(--badgeBg);
      border:1px solid var(--badgeLine);
      white-space:nowrap;
    }

    .date{
      font-size:.9rem;
      color:var(--muted);
      white-space:nowrap;
    }

    h1{
      margin: 0 0 10px;
      font-size: 1.7rem;
      line-height: 1.15;
      font-weight: 900;
      letter-spacing: -.02em;
    }

    .bajada{
      margin: 0 0 16px;
      color:var(--muted);
      line-height: 1.55;
      font-size: 1.02rem;
    }

    .divider{
      height:1px;
      background:var(--line);
      margin: 18px 0 14px;
    }

    .cuerpo{
      color: var(--text);
      line-height: 1.7;
      font-size: 1rem;
      white-space: pre-line;
    }

    .footer-actions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top: 14px;
    }

    .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding: 10px 12px;
      border-radius: 12px;
      border:1px solid var(--line);
      background: var(--card);
      color: var(--text);
      text-decoration:none;
      font-weight:800;
      transition: transform .15s ease;
    }
    .btn:hover{ transform: translateY(-1px); }

    .btn-dark{
      background:#111827;
      border-color:#111827;
      color:#fff;
    }
  </style>
</head>
<body>

  <div class="wrap">
    <div class="topbar">
      <div class="brand">HeartCom</div>
    </div>

    <article class="card">
      <?php if ($imgSrc): ?>
        <div class="media">
          <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Imagen de la noticia">
        </div>
      <?php endif; ?>

      <div class="content">
        <div class="meta">
          <span class="badge"><?= htmlspecialchars($n['categorias_noticias']) ?></span>
          <span class="date"><?= htmlspecialchars($fecha) ?></span>
        </div>

        <h1><?= htmlspecialchars($n['titulo']) ?></h1>

        <?php if (!empty($n['bajada'])): ?>
          <p class="bajada"><?= htmlspecialchars($n['bajada']) ?></p>
        <?php endif; ?>

        <div class="divider"></div>

        <div class="cuerpo"><?= htmlspecialchars($n['cuerpo']) ?></div>

        <div class="footer-actions">
          <a class="btn" href="../index.php">Volver al inicio</a>
        </div>
      </div>
    </article>
  </div>

</body>
</html>
