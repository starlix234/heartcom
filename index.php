<?php include "lib/mostrar-proyecto-index.php" ?>
<?php include('lib/navbar-sesion.php')?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos-2.css">

    <title>HeartCom</title>
</head>

<body class="bg-light">
<header class="banner">
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold" href="<?= $base ?>index.php">HeartCom</a>

    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <!-- IZQUIERDA -->
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link" href="<?= $base ?>index.php">Inicio</a>
        </li>

        <?php if (can($rol, [1,2,3])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>modulo-certificados/solicitudes.php">Certificados</a>
          </li>
        <?php endif; ?>

        <?php if (can($rol, [1,2,3])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>modulo-reservas/reservas.php">Reservas</a>
          </li>
        <?php endif; ?>

        <?php if (can($rol, [1,2,3])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>modulo-proyecto/proyectos.php">Proyectos</a>
          </li>
        <?php endif; ?>

        <?php if (can($rol, [1,2,3])): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>modulo-noticias/noticias.php">Noticias</a>
          </li>
        <?php endif; ?>

        <!-- ADMIN / MODERADOR -->
        <?php if (can($rol, [1,2])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="adminMenu" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Administración
            </a>

            <ul class="dropdown-menu" aria-labelledby="adminMenu">
            
              <!-- SOLO ROL 1 -->
              <?php if (can($rol, [1])): ?>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="<?= $base ?>modulo-usuarios/administrar-rol-usuarios.php">
                    Administrar Roles
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

      </ul>

      <!-- DERECHA -->
      <ul class="navbar-nav ms-auto align-items-lg-center">

        <?php if (!empty($nombreRol)): ?>
          <li class="nav-item">
            <span class="navbar-text me-3">
              Rol: <strong><?= htmlspecialchars($nombreRol) ?></strong>
            </span>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="<?= $base ?>perfil.php">Perfil</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-danger" href="<?= $base ?>lib/cerrar-sesion.php">Cerrar sesión</a>
        </li>

      </ul>

    </div>
  </div>
</nav>
</header>

<div class="container">

<!-- ================= PROYECTOS ================= -->
<section class="mb-5">
    <h2 class="mb-4 text-center">Últimos Proyectos</h2>

  
</section>

<!-- ================= NOTICIAS ================= -->
<section class="mb-5">
    <h2 class="mb-4 text-center">Noticias del Barrio</h2>

    <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-header bg-primary text-white">
            Módulo de Noticias
        </div>

        <div class="card-body">
            <h5 class="card-title">Gestión de Noticias</h5>

            <p class="card-text">
                Desde este módulo puedes crear nuevas noticias ,
                visualizar las publicaciones existentes y administrarlas
                de forma sencilla.
            </p>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item">✔ Crear noticias</li>
                <li class="list-group-item">✔ Editar publicaciones</li>
                <li class="list-group-item">✔ Eliminar noticias</li>
                <li class="list-group-item">✔ Visualizar por categoría</li>
            </ul>

            <div class="d-grid gap-2">
                <a href="/heartcom/modulo-noticias/crear.php" class="btn btn-success">
                    Crear Noticia
                </a>
            </div>
        </div>

        <div class="card-footer text-muted text-center">
            Administración del Barrio
        </div>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</footer>


</body>
</html>
