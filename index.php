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
$logueado = !empty($_SESSION['id_usuario']); // o la variable que uses para login

?>


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

          <!-- ADMINISTRAR NOTICIAS: SOLO ROL 1 y 2 -->
          <?php if (can($rol, [1,2])): ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/modulo-noticias/', $current) ?>"<?= ariaCurrent('/modulo-noticias/', $current) ?>
                 href="<?= $base ?>modulo-noticias/noticias.php">Administrar Noticias</a>
            </li>
          <?php endif; ?>

          <!-- ADMIN / MODERADOR -->
          <?php if (can($rol, [1,2])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle<?= active('/modulo-usuarios/', $current) ?>"
                 href="#" id="adminMenu" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                Administración
              </a>

              <ul class="dropdown-menu" aria-labelledby="adminMenu">

                <?php if (can($rol, [1])): ?>
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

          <?php if ($logueado && !empty($nombreRol)): ?>
            <li class="nav-item">
              <span class="navbar-text me-3">
                Rol: <strong><?= htmlspecialchars($nombreRol) ?></strong>
              </span>
            </li>
          <?php endif; ?>

          <?php if ($logueado): ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/perfil.php', $current) ?>"<?= ariaCurrent('/perfil.php', $current) ?>
                 href="<?= $base ?>perfil.php">Perfil</a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-danger" href="<?= $base ?>lib/cerrar-sesion.php">Cerrar sesión</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link<?= active('/login.php', $current) ?>"<?= ariaCurrent('/login.php', $current) ?>
                 href="<?= $base ?>login.php">Iniciar sesión</a>
            </li>
          <?php endif; ?>

        </ul>

      </div>
    </div>
  </nav>
</header>

<main>

<?php include("modulo-noticias/ver-noticia-cliente.php")?>

</main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</footer>


</body>
</html>
