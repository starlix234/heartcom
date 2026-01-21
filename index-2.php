
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white">
    <div class="container-fluid px-lg-5">
      
      <a class="navbar-brand" href="<?= $base ?>index.php">
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
    
</body>
</html>

