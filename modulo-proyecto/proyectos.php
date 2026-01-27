<?php include("../lib/roles.php");?> 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proyectos</title>

  <link rel="stylesheet" href="../assets/css/estilos-dashboard.css"> 
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="../assets/img/logo/logo_heartcom.ico">
</head>

<body>

   <aside class="sidebar">
        <h2>Gestion de Proyectos</h2>
        <nav>
          <?php if ($rol === 1 || $rol === 2): ?>
            <a href="#crear" class="menu-item">
                <i class="fa-solid fa-house"></i> Crear Proyectos 
            </a>
          <?php endif; ?>
          <?php if ($rol === 1 || $rol === 2): ?>

            <a href="#admin" class="menu-item">
                <i class="fa-solid fa-chart-simple"></i> Administrar Proyecto
            </a>
            <?php endif; ?>

            <a href="#mostrar" class="menu-item">
                <i class="fa-solid fa-user-group"></i> Proyectos
            </a>
          <?php if ($rol === 3): ?>

           <a href="#post" class="menu-item">
                <i class="fa-solid fa-file-lines"></i> Mis Postulaciones
            </a>
          <?php endif; ?>
           <?php if ($rol === 1 || $rol === 2): ?>
            <a href="#adminis" class="menu-item">
                <i class="fa-solid fa-file-lines"></i> Administrar Postulaciones
            </a>
          <?php endif; ?>
            <a href="../index.php" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Proyectos</h1>
            <p>Bienvenido a tu panel de control</p>
        </header>
        <?php if ($rol === 1 || $rol === 2): ?>

          <div class="chart-container" id="crear">
            <?php include("crear-proyecto.php")?>
          </div>
        <?php endif; ?>
        <?php if ($rol === 1 || $rol === 2): ?>

          <div class="chart-container" id="admin">
            <?php include("administrar-proyectos.php")?>
          </div>
           <div class="chart-container" id="admin">
            <?php include("administrar-postulaciones.php")?>
          </div>
        <?php endif; ?>
          <div class="chart-container" id="mostrar">
            <?php include("mostrar-proyecto.php")?>
          </div>
        <?php if ($rol === 3): ?>

          <div class="chart-container" id="post">
            <?php include("mis-postulaciones.php")?>
          </div>
        <?php endif; ?>
    </main>



  <script>
    // scroll suave para el sidebar
    document.querySelectorAll('.menu-item[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const target = document.querySelector(a.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  </script>

</body>
</html>
