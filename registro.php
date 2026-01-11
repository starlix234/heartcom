<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Vecino</title>
</head>
<script src="assets/js/verificar-formato-rut.js"></script>
<body>

<h2>Registro de Miembro</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">
        <?= htmlspecialchars($_GET['error']) ?>
    </p>
<?php endif; ?>

<form 
    action="lib/procesar_registro.php" 
    method="POST" 
    onsubmit="return validarFormulario();"
>

    <label>Primer Nombre:</label>
    <input type="text" name="p_nombre" required><br>

    <label>Segundo Nombre:</label>
    <input type="text" name="s_nombre" required><br>

    <label>Apellido Paterno:</label>
    <input type="text" name="ap_paterno" required><br>

    <label>Apellido Materno:</label>
    <input type="text" name="ap_materno" required><br>

    <label>Fecha de Nacimiento:</label>
    <input type="date" name="fecha_nac" id="fecha_nac" required><br>

    <label>RUT:</label>
    <input type="text" name="rut" oninput="formatearRUT(this)" placeholder="Ej: 12.345.678-9" required><br>

    <label>Teléfono:</label>
    <input type="text" name="telefono" required><br>

    <label>Correo electrónico:</label>
    <input type="email" name="correo" id="correo" required>
    <small id="errorCorreo" style="color:red;"></small><br>

    <label>Dirección:</label>
    <input type="text" name="direccion" required><br>

    <label>Contraseña:</label>
    <input type="password" name="clave" required><br>

    <button type="submit">Registrarme</button>
</form>

<!-- JS externo -->
<script src="assets/js/verificar-formato-correo.js"></script>
<!-- Validación correo -->
<script>
function validarFormulario() {
    const correo = document.getElementById("correo").value;
    const errorCorreo = document.getElementById("errorCorreo");

    if (!verificarFormatoCorreo(correo)) {
        errorCorreo.textContent =
            "Solo se permiten correos @gmail.com o @hotmail.com";
        return false;
    }

    errorCorreo.textContent = "";
    return true;
}
</script>

</body>
</html>
