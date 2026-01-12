<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Vecino</title>
</head>
<script src="assets/js/verificar-formato-rut.js"></script>
<script src="assets/js/validar-contrasena.js"></script>
<script src="assets/js/verificar-formato-correo.js"></script>
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
    <input type="text" name="p_nombre" required ><br>

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
    <input type="password" name="clave" required>
    <small id="errorPassword" style="color:red;"></small><br>

    <button type="submit">Registrarme</button>
</form>
    <!--Script de validación de formulario -->
    <script>
    function validarFormulario() {
        // Validar formato de correo
        const correo = document.getElementById("correo").value;
        const errorCorreo = document.getElementById("errorCorreo");

        if (!verificarFormatoCorreo(correo)) {
            errorCorreo.textContent =
                "Solo se permiten correos con dominio @gmail.com o @hotmail.com";
            return false;
        }

        errorCorreo.textContent = "";

        // Validar formato de contraseña
        const password = document.querySelector("input[name='clave']").value;
        const errorPassword = document.getElementById("errorPassword");

        if (!validarPassword(password)) {
            errorPassword.textContent =
                "La contraseña debe tener entre 5 y 15 caracteres, incluir mayúscula, minúscula y número.";
            return false;
        } else {
            errorPassword.textContent = "";
        }
        
        // Validar mayoría de edad
        const fechaNac = document.getElementById("fecha_nac").value;

        if (fechaNac) {
            const hoy = new Date();
            const nacimiento = new Date(fechaNac);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const m = hoy.getMonth() - nacimiento.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }
            if (edad < 18) {
                alert("Debes ser mayor de 18 años");
                return false;
            }
        }
        return true;
    }

    </script>

</body>
</html>
