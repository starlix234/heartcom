
<?php include("../lib/roles.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reservas</title>

  <link rel="stylesheet" href="../assets/css/estilos-dashboard.css">
    <link rel="stylesheet" href="../assets/css/estilo-tabla-dashboard.css">
    

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
<body>

    <aside class="sidebar">
        <h2>Reservas</h2>
        <nav>
            <?php if ($rol === 3): ?>

            <a href="#reservas" class="menu-item">
                <i class="fa-solid fa-house"></i> Reserva
            </a>
            <?php endif; ?>

            <a href="#gestion" class="menu-item">
                <i class="fa-solid fa-chart-simple"></i> Gestionar Solicitud Reserva
            </a>
            <?php if ($rol === 3): ?>

            <a href="#reservaciones" class="menu-item">
                <i class="fa-solid fa-user-group"></i> Mis Reservaciones
            </a>
            <?php endif; ?>         
            
            <a href="../index.php" class="menu-item">
                <i class="fa-solid fa-gear"></i> Volver Inicio
            </a>
          
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Reservas</h1>
            <p>Bienvenido a su gestion de reservas </p>
        </header>

        <?php if ($rol === 3): ?>
        <div class="chart-container">
            <div class="chart-header">
                <h3>Solicitar Reservas</h3>
                 <?php include("crear-espacio-reserva.php")?>
            </div>

        </div>
        <?php endif; ?>

        <?php if ($rol === 1 || $rol === 2): ?>

        <div class="container" style="postion:relative;left:10px;">
                <h3>Gestionar Solicitudes de Reservas</h3>
                <?php include("administrar-reservas.php")?>
            </div>
        <?php endif; ?>

            
        </div>
        <?php if ($rol === 3): ?>
         <div class="chart-container">
            <div class="chart-header">
                <h3>Mostrar mis reservas</h3>
                <?php include("mostrar-reserva.php")?>
            </div>
            
        </div>
      <?php endif; ?>

    </main>

    
</body>
</html>