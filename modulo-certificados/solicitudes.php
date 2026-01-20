<?php include("../lib/roles.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Solicitudes</title>

  <link rel="stylesheet" href="../assets/css/estilos-dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

  <aside class="sidebar">
    <h2>Solicitudes</h2>

    <nav>
      <?php if ($rol === 3): ?>
        <a href="#solicitar" class="menu-item">
          <i class="fa-solid fa-file-circle-plus"></i> Realizar Solicitud
        </a>

        <a href="#mis-solicitudes" class="menu-item">
          <i class="fa-solid fa-user"></i> Mis Solicitudes
        </a>
      <?php endif; ?>

      <?php if ($rol === 1 || $rol === 2): ?>
        <a href="#gestionar" class="menu-item">
          <i class="fa-solid fa-list-check"></i> Gestionar Solicitudes
        </a>
      <?php endif; ?>

      <a href="../index.php" class="menu-item">
        <i class="fa-solid fa-arrow-left"></i> Volver
      </a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="page-header">
      <h1>Solicitudes</h1>

      <?php if ($rol === 1 || $rol === 2): ?>
        <p>Panel de administración: aprueba o rechaza solicitudes.</p>
      <?php elseif ($rol === 3): ?>
        <p>Como miembro puedes solicitar certificados y revisar su estado.</p>
      <?php else: ?>
        <p>Acceso restringido.</p>
      <?php endif; ?>
    </header>

    <!-- ROL 3: Solicitar -->
    <?php if ($rol === 3): ?>
      <section class="section" id="solicitar">
        <?php include("solicitud-certificado.php"); ?>
      </section>
    <?php endif; ?>

    <!-- ROL 1 o 2: Administrar -->
    <?php if ($rol === 1 || $rol === 2): ?>
      <section class="section" id="gestionar">
        <?php include("administrar-certificados.php"); ?>
      </section>
    <?php endif; ?>

    <!-- ROL 3: Mis solicitudes -->
    <?php if ($rol === 3): ?>
      <section class="section" id="mis-solicitudes">
        <?php include("solicitud-cliente.php"); ?>
      </section>
    <?php endif; ?>

    <!-- Si no es 1/2/3 -->
    <?php if ($rol !== 1 && $rol !== 2 && $rol !== 3): ?>
      <section class="section">
        <div class="alert-box">
          No tienes permisos para ver este módulo.
        </div>
      </section>
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
