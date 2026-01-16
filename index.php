<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HeartCom Tu Barrio - Panel Principal</title>
    <style>
        /* --- VARIABLES DE DISEÑO --- */
        :root {
            --primary-color: #2C5282; /* Azul sólido, transmite confianza */
            --secondary-color: #E2E8F0; /* Gris muy claro para fondos */
            --accent-color: #2B6CB0; /* Azul más brillante para hover */
            --text-dark: #1A202C; /* Casi negro para máximo contraste */
            --text-white: #ffffff;
            --danger-color: #C53030; /* Rojo oscuro para salir */
            --border-radius: 12px;
        }

        /* --- RESET Y BASE --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuentes claras y sin remates */
            background-color: #f7f9fc;
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        .container {
            width: 100%;
            max-width: 600px; /* Limitamos el ancho para que no se disperse la vista */
            padding: 20px;
            margin-top: 20px;
        }

        /* --- ENCABEZADO --- */
        header {
            text-align: center;
            margin-bottom: 40px;
            background: white;
            padding: 30px 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-bottom: 4px solid var(--primary-color);
        }

        h1 {
            font-size: 2rem; /* 32px - Grande y claro */
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        p.subtitle {
            font-size: 1.2rem;
            color: #4A5568;
        }

        /* --- GRILLA DE BOTONES --- */
        .dashboard-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 40px;
        }

        /* ESTILOS DE LAS TARJETAS / BOTONES */
        .action-card {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Texto a la izq, flecha a la der */
            background-color: white;
            padding: 25px 30px;
            text-decoration: none;
            color: var(--text-dark);
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            font-size: 1.25rem; /* 20px */
            font-weight: 600;
        }

        .action-card:hover, .action-card:focus {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            background-color: #ebf8ff; /* Fondo azul muy pálido al pasar el mouse */
        }

        .icon {
            font-size: 1.8rem;
            margin-right: 15px;
        }

        .arrow {
            color: var(--primary-color);
            font-weight: bold;
        }

        /* Estilo especial para admin */
        .card-admin {
            border-left: 6px solid #D69E2E; /* Borde dorado para diferenciar admin */
        }

        /* --- BARRA DE USUARIO (PERFIL Y SALIR) --- */
        .user-bar {
            display: flex;
            flex-direction: column; /* En móviles uno debajo de otro */
            gap: 15px;
            border-top: 1px solid #ccc;
            padding-top: 30px;
        }

        .btn-secondary {
            display: block;
            text-align: center;
            padding: 15px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .btn-profile {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            border: 1px solid #cbd5e0;
        }

        .btn-logout {
            background-color: white;
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
        }

        .btn-logout:hover {
            background-color: var(--danger-color);
            color: white;
        }

        /* --- RESPONSIVE (CELULARES) --- */
        @media (min-width: 480px) {
            .user-bar {
                flex-direction: row; /* En PC uno al lado del otro */
                justify-content: space-between;
            }
            .btn-secondary {
                width: 48%; /* Mitad y mitad */
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>HeartCom</h1>
            <p class="subtitle">Panel de Vecinos</p>
        </header>

        <nav class="dashboard-grid" aria-label="Menú principal">
            
            <a href="modulo-certificados/solicitudes.php" class="action-card">
                <span><span class="icon">📄</span> Solicitar Certificados</span>
                <span class="arrow">➜</span>
            </a>

            <a href="modulo-reservas/panel-reservas.php" class="action-card">
                <span><span class="icon">📅</span> Reservar Espacios</span>
                <span class="arrow">➜</span>
            </a>

            <a href="modulo-usuarios/administrar-rol-usuarios.php" class="action-card card-admin">
                <span><span class="icon">⚙️</span> Administrar Usuarios</span>
                <span class="arrow">➜</span>
            </a>

        </nav>

        <div class="user-bar">
            <a href="perfil.php" class="btn-secondary btn-profile">
                👤 Editar Mi Perfil
            </a>
            <a href="lib/cerrar-sesion.php" class="btn-secondary btn-logout">
                ✖ Cerrar Sesión
            </a>
        </div>
    </div>

</body>
</html>