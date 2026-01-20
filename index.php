<?php include ("lib/mostrar-proyecto-index.php") ?>
<?php include('lib/navbar-sesion.php')?>
<?php
function active(string $needle, string $current): string {
  return (strpos($current, $needle) !== false) ? ' active' : '';
}
function ariaCurrent(string $needle, string $current): string {
  return (strpos($current, $needle) !== false) ? ' aria-current="page"' : '';
}

$current = $_SERVER['PHP_SELF'] ?? '';
$logueado = !empty($_SESSION['id_usuario']);

// Aseguramos que la variable de proyectos sea un array válido
// Asumimos que 'lib/mostrar-proyecto-index.php' genera la variable $proyecto
$listaProyectos = (isset($proyecto) && is_array($proyecto)) ? $proyecto : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
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
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link<?= active('/index.php', $current) ?>"<?= ariaCurrent('/index.php', $current) ?>
               href="<?= $base ?>index.php">Inicio</a>
          </li>

          <?php if (can($rol, [1,2,3])): ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/modulo-certificados/', $current) ?>"<?= ariaCurrent('/modulo-certificados/', $current) ?>
                 href="<?= $base ?>modulo-certificados/solicitudes.php">Certificados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link<?= active('/modulo-reservas/', $current) ?>"<?= ariaCurrent('/modulo-reservas/', $current) ?>
                 href="<?= $base ?>modulo-reservas/reservas.php">Reservas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link<?= active('/modulo-proyecto/', $current) ?>"<?= ariaCurrent('/modulo-proyecto/', $current) ?>
                 href="<?= $base ?>modulo-proyecto/proyectos.php">Proyectos</a>
            </li>
          <?php endif; ?>

          <?php if (can($rol, [1,2])): ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/modulo-noticias/', $current) ?>"<?= ariaCurrent('/modulo-noticias/', $current) ?>
                 href="<?= $base ?>modulo-noticias/noticias.php">Administrar Noticias</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle<?= active('/modulo-usuarios/', $current) ?>"
                 href="#" id="adminMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Administración
              </a>
              <ul class="dropdown-menu" aria-labelledby="adminMenu">
                <?php if (can($rol, [1])): ?>
                  <li>
                    <a class="dropdown-item" href="<?= $base ?>modulo-usuarios/administrar-rol-usuarios.php">Administrar Roles</a>
                  </li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ms-auto align-items-lg-center">
          <?php if ($logueado && !empty($nombreRol)): ?>
            <li class="nav-item">
              <span class="navbar-text me-3">Rol: <strong><?= htmlspecialchars($nombreRol) ?></strong></span>
            </li>
          <?php endif; ?>

          <?php if ($logueado): ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/perfil.php', $current) ?>" href="<?= $base ?>perfil.php">Perfil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" href="<?= $base ?>lib/cerrar-sesion.php">Cerrar sesión</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/login.php', $current) ?>" href="<?= $base ?>login.php">Iniciar sesión</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main>

    <?php include("modulo-noticias/ver-noticia-cliente.php")?>

    <section class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-primary border-bottom pb-2">Proyectos Comunitarios</h2>
                <p class="text-muted">Participa en las iniciativas activas de tu barrio.</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($listaProyectos)): ?>
                <div class="col-12">
                    <div class="alert alert-secondary text-center py-4">
                        <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                        No hay proyectos disponibles en este momento.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($listaProyectos as $p): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0">
                                        <?= htmlspecialchars($p['nombre_proyecto'] ?? 'Sin título') ?>
                                    </h5>
                                    <?php if(isset($p['nombre_estado'])): ?>
                                        <span class="badge bg-success rounded-pill">
                                            <?= htmlspecialchars($p['nombre_estado']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h6 class="card-subtitle mb-3 text-muted small">
                                    <i class="bi bi-tag-fill me-1"></i> 
                                    <?= htmlspecialchars($p['nombre_tipo'] ?? 'General') ?>
                                </h6>

                                <p class="card-text text-secondary">
                                    <?= htmlspecialchars(substr($p['descripcion'] ?? '', 0, 90)) ?>...
                                </p>
                            </div>
                            
                            <ul class="list-group list-group-flush small bg-light">
                                <li class="list-group-item bg-transparent d-flex justify-content-between">
                                    <span><i class="bi bi-calendar-event text-primary me-1"></i> Inicio:</span>
                                    <span class="fw-semibold"><?= htmlspecialchars($p['fecha_inicio'] ?? '--') ?></span>
                                </li>
                                <li class="list-group-item bg-transparent d-flex justify-content-between">
                                    <span><i class="bi bi-people-fill text-primary me-1"></i> Cupos:</span>
                                    <span class="fw-semibold"><?= htmlspecialchars($p['cupo_maximo'] ?? '0') ?></span>
                                </li>
                            </ul>

                            <div class="card-footer bg-white border-top-0 pt-3 pb-3">
                                <a href="modulo-proyecto/detalle-proyecto.php?id_proyecto=<?= $p['id_proyecto'] ?>" 
                                   class="btn btn-primary w-100">
                                   Ver Detalles / Postular
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>