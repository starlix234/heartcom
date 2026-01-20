<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/estilo-dashboard-usuarios.css">
</head>
<body>

    <aside class="sidebar">
        <h2>Mi Dashboard</h2>
        
        <nav>
            <a href="#publicar" class="menu-item">
                <i class="fa-solid fa-house"></i>Publicar Noticia
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-chart-simple"></i> Análisis
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-user-group"></i> Clientes
            </a>
            <a href="#" class="menu-item active">
                <i class="fa-solid fa-cart-shopping"></i> Productos
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-file-lines"></i> Reportes
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-gear"></i> Configuración
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Noticias</h1>
            <p>Bienvenido a tu panel de Noticias</p>
        </header>            
        <div id="#publicar" class="chart-container">
          <?php include("publicar-noticia.php")?>
            
        </div>
        <div id="#publicar" class="chart-container">
          <?php include("publicar-noticia.php")?>
            
        </div>
    </main>

    
</body>
</html>