<?php include("../lib/roles.php"); ?>
<?php
error_reporting(error_reporting() & ~E_NOTICE);

/**
 * $rol debería venir de roles.php
 * - 1 y 2: admin/mod
 * - 3: usuario normal
 * - null: sin sesión (o no seteado)
 */
$esAdminNoticias = ($rol === 1 || $rol === 2);
$esPublicoNoticias = (!$esAdminNoticias); // rol 3 o sin sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Dashboard</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="../assets/css/estilos-dashboard.css">
  <link rel="icon" href="../assets/img/logo/logo_heartcom.ico">
  <style>
    /* Corrige el “desafase” al navegar por #anclas */
    .section { scroll-margin-top: 18px; }
  </style>
</head>

<body>

  <aside class="sidebar">
    <h2>Panel de Noticias</h2>

    <nav>
      <?php if ($esAdminNoticias): ?>
        <a href="#publicar" class="menu-item">
          <i class="fa-solid fa-pen-to-square"></i> Publicar Noticia
        </a>
        <a href="#admin" class="menu-item">
          <i class="fa-solid fa-list-check"></i> Administrar Noticias
        </a>
      <?php endif; ?>

      <?php if ($esPublicoNoticias): ?>
        <a href="#noti" class="menu-item">
          <i class="fa-solid fa-newspaper"></i> Noticias Públicas
        </a>
      <?php endif; ?>

      <a href="../index.php" class="menu-item">
        <i class="fa-solid fa-arrow-left"></i> Volver
      </a>
    </nav>
  </aside>

  <main class="main-content">
    <header>
      <h1>Noticias</h1>
      <p>Bienvenido a tu panel de Noticias</p>
    </header>

    <?php if ($esAdminNoticias): ?>
      <section id="publicar" class="chart-container section">
        <?php include("publicar-noticia.php"); ?>
      </section>

      <section id="admin" class="chart-container section">
        <?php include("ver-noticia.php"); ?>
      </section>
    <?php endif; ?>

   

  </main>

</body>
</html>
