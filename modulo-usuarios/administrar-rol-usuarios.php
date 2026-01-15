<?php include("../lib/mostrar-usuario.php")?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios y Roles - HeartCom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HeartCom - Administrador</a>
        <div class="d-flex">
            <a href="panel.php" class="btn btn-outline-light btn-sm me-2">Volver al panel</a>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mb-3">Listado de usuarios y su rol</h1>
    <p class="text-muted">
        Aquí puedes ver todos los usuarios registrados en el sistema y cambiar su rol entre Miembro y Jefe de Junta de Vecinos.
    </p>

    <?php if (!empty($_GET['msg'])): ?>
        <div class="alert alert-success py-2">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger py-2">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            Usuarios registrados
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
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
                        <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= (int)$u['id_usuario'] ?></td>
                            <td>
                                <?= htmlspecialchars(
                                    $u['p_nombre'] . ' ' .
                                    $u['s_nombre'] . ' ' .
                                    $u['ap_paterno'] . ' ' .
                                    $u['ap_materno']
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
                                        <option value="">-- Seleccionar rol --</option>
                                        <?php foreach ($roles as $rol): ?>
                                            <option 
                                                value="<?= (int)$rol['id_rol'] ?>"
                                                <?= ($rol['id_rol'] == $u['id_rol']) ? 'selected' : '' ?>
                                            >
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
</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
