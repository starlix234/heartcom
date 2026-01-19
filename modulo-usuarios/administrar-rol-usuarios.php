<?php include("../lib/mostrar-usuario.php") ?>
<?php include("../lib/permisos-admin.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios - HeartCom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap (solo para tablas y forms, no afecta el template) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ===== ESTILOS DEL TEMPLATE DASHBOARD ===== -->
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --bg-color: #f8fafc;
            --primary: #2563eb;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-color);
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--white);
            padding: 1.5rem;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            font-weight: 700;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: #94a3b8;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: var(--primary);
            color: var(--white);
        }

        /* MAIN */
        .main-content {
            margin-left: 260px;
            padding: 2rem 3rem;
            width: 100%;
        }

        header h1 {
            font-size: 2rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        header p {
            color: var(--text-gray);
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar">
    <h2>HeartCom</h2>
    <nav>
        <a href="panel.php" class="menu-item">
            <i class="fa-solid fa-house"></i> Panel
        </a>
        <a href="#" class="menu-item active">
            <i class="fa-solid fa-users"></i> Usuarios
        </a>
        <a href="logout.php" class="menu-item">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
        </a>
    </nav>
</aside>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<main class="main-content">

    <header class="mb-4">
        <h1>Listado de usuarios</h1>
        <p>Gestiona los roles de los usuarios del sistema</p>
    </header>

    <?php if (!empty($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre completo</th>
                        <th>RUT</th>
                        <th>Correo</th>
                        <th>Rol actual</th>
                        <th>Cambiar rol</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay usuarios registrados</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= (int)$u['id_usuario'] ?></td>
                            <td>
                                <?= htmlspecialchars(
                                    $u['p_nombre'].' '.$u['s_nombre'].' '.$u['ap_paterno'].' '.$u['ap_materno']
                                ) ?>
                            </td>
                            <td><?= htmlspecialchars($u['rut']) ?></td>
                            <td><?= htmlspecialchars($u['correo']) ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    <?= htmlspecialchars($u['nombre_rol']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="../lib/actualizar-rol-usuario.php" method="post" class="d-flex gap-2">
                                    <input type="hidden" name="id_usuario" value="<?= (int)$u['id_usuario'] ?>">

                                    <select name="id_rol" class="form-select form-select-sm" required>
                                        <option value="">Seleccionar</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= (int)$rol['id_rol'] ?>"
                                                <?= $rol['id_rol'] == $u['id_rol'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($rol['nombre_rol']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Actualizar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

</body>
</html>
