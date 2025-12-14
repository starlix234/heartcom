<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Vecino</title>
</head>
<body>

<h2>Registro de Miembro</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<form action="lib/procesar_registro.php" method="POST">

    <label>Primer Nombre:</label>
    <input type="text" name="p_nombre" required><br>

    <label>Segundo Nombre:</label>
    <input type="text" name="s_nombre" required><br>

    <label>Apellido Paterno:</label>
    <input type="text" name="ap_paterno" required><br>

    <label>Apellido Materno:</label>
    <input type="text" name="ap_materno" required><br>

    <label>Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nac" required><br>

    <label>RUT:</label>
    <input type="text" name="rut" required><br>

    <label>Teléfono:</label>
    <input type="text" name="telefono" required><br>

    <label>Correo electrónico:</label>
    <input type="email" name="correo" required><br>

    <label>Dirección:</label>
    <input type="text" name="direccion" required><br>

    <label>Contraseña:</label>
    <input type="password" name="clave" required><br>

    <button type="submit">Registrarme</button>
</form>

</body>
</html>
