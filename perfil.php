<?php include("lib/cambiar-mi-perfil.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - HeartCom</title>
    <link rel="stylesheet" href="assets/css/estilo-fromulario-mi-perfil.css">
    <link rel="stylesheet" href="assets/css/estilos.css"> <style>
        .btn-volver {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }
    </style>
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
</head>
<body>

<div class="page">

    <div class="card">

        <div class="card__header">
            <div>
                <h2 class="card__title">Editar Perfil</h2>
                <p class="card__subtitle">
                    Hola,
                    <strong><?= htmlspecialchars($usuario['p_nombre'].' '.$usuario['ap_paterno']) ?></strong>
                </p>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert-success">
                ¡Datos actualizados correctamente!
            </div>
        <?php endif; ?>

        <form action="lib/actualizar-perfil.php" method="POST" class="form">

            <div class="field">
                <label class="label">Teléfono</label>
                <input
                    type="text"
                    name="telefono"
                    class="control"
                    value="<?= htmlspecialchars($usuario['telefono']) ?>"
                    required
                >
            </div>

            <div class="field">
                <label class="label">Correo Electrónico</label>
                <input
                    type="email"
                    name="correo"
                    class="control"
                    value="<?= htmlspecialchars($usuario['correo']) ?>"
                    required
                >
            </div>

            <div class="field">
                <label class="label">Nueva Contraseña</label>
                <input
                    type="password"
                    name="clave"
                    class="control"
                    placeholder="Dejar en blanco si no desea cambiarla"
                >
            </div>

            <button type="submit" class="btn">
                Guardar Cambios
            </button>
        </form>

        <a href="index.php" class="btn-volver">
            ← Volver Inicio
        </a>

    </div>

</div>

</body>

</html>