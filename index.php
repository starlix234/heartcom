<?php include ("lib/mostrar-proyecto-index.php") ?>
<?php include('lib/navbar-sesion.php')?>
<?php
// Funciones de ayuda para el menú
function active(string $needle, string $current): string {
  return (strpos($current, $needle) !== false) ? ' active' : '';
}
function ariaCurrent(string $needle, string $current): string {
  return (strpos($current, $needle) !== false) ? ' aria-current="page"' : '';
}

$current = $_SERVER['PHP_SELF'] ?? '';
$logueado = !empty($_SESSION['id_usuario']);

// Validación básica de variable
$listaProyectos = (isset($proyecto) && is_array($proyecto)) ? $proyecto : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartCom</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
</head>

<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white sombra">
    <div class="container-fluid px-lg-5">
      
      <a class="navbar-brand" href="<?= $base ?>index.php">
        <img src="assets/img/logo-menu.png" style="width:100px;" alt="Logo HeartCom">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto ms-lg-4">
          <li class="nav-item">
            <a class="nav-link<?= active('/index.php', $current) ?>" href="<?= $base ?>index.php">Inicio</a>
          </li>

          <?php if (can($rol, [1,2,3])): ?>
            <li class="nav-item"><a class="nav-link" href="<?= $base ?>modulo-certificados/solicitudes.php">Certificados</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $base ?>modulo-reservas/reservas.php">Reservas</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $base ?>modulo-proyecto/proyectos.php">Proyectos</a></li>
          <?php endif; ?>

          <?php if (can($rol, [1,2])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Administración</a>
              <ul class="dropdown-menu border-0 shadow">
                 <li><a class="dropdown-item" href="<?= $base ?>modulo-noticias/noticias.php">Noticias</a></li>
                <?php if (can($rol, [1])): ?>
                  <li><a class="dropdown-item" href="<?= $base ?>modulo-usuarios/administrar-rol-usuarios.php">Roles</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto align-items-lg-center">
            <?php if ($logueado): ?>
                <li class="nav-item me-3"><span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2"><?= htmlspecialchars($nombreRol) ?></span></li>
                <li class="nav-item"><a class="btn btn-outline-primary rounded-pill px-4 btn-sm" href="<?= $base ?>perfil.php">Perfil</a></li>
                <li class="nav-item ms-2"><a class="nav-link text-secondary" href="<?= $base ?>lib/cerrar-sesion.php">Salir</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="btn btn-primary-custom" href="<?= $base ?>login.php">Ingresar</a></li>
            <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main style="margin-top: 80px;"> <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold text-dark mb-3">
                        Bienvenido a <span style="color: #2b4eff;">HeartCom</span>
                    </h1>
                    <p class="lead text-secondary mb-4">
                        Conectando vecinos, mejorando vidas. La plataforma integral para la gestión de tu comunidad.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#proyectos" class="btn btn-primary-custom btn-lg">Ver Proyectos</a>
                        <?php if (!$logueado): ?>
                            <a href="login.php" class="btn btn-outline-dark btn-lg rounded-pill">Unirse</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-lg-6 text-center">
                    <img src="assets/img/banner.png" alt="Comunidad Banner" class="hero-banner-img img-fluid">
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <?php include("modulo-noticias/ver-noticia-cliente.php")?>
    </div>

    <section class="container my-5" id="proyectos">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Proyectos Activos</h2>
            <p class="text-muted">Participa en las iniciativas de tu barrio</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($proyectosRecientes)): ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">No hay proyectos disponibles por el momento.</h5>
                </div>
            <?php else: ?>
                <?php foreach ($proyectosRecientes as $p): ?>
                    <div class="col">
                        <div class="card h-100 card-proyecto p-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                                        <?= htmlspecialchars($p['nombre_tipo'] ?? 'Proyecto') ?>
                                    </span>
                                    <?php if(isset($p['nombre_estado'])): ?>
                                        <span class="badge bg-success">
                                            <?= htmlspecialchars($p['nombre_estado']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($p['nombre_proyecto'] ?? 'Sin título') ?></h5>
                                <p class="card-text text-secondary small">
                                    <?= htmlspecialchars(substr($p['descripcion'] ?? '', 0, 90)) ?>...
                                </p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-calendar3"></i> Inicio: <?= htmlspecialchars($p['fecha_inicio'] ?? '--') ?>
                                </small>
                                <a href="modulo-proyecto/proyecto-detalle.php??id_proyecto=<?= $p['id_proyecto'] ?>" 
                                   class="btn btn-outline-primary w-100 rounded-pill btn-sm">
                                   Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<footer class="text-center">
    <div class="container">
        <p class="mb-0 text-white-50">&copy; <?= date('Y') ?> HeartCom. Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>