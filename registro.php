<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Miembro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="assets/css/estilos.css">

    <!-- Scripts de validación -->
    <script src="assets/js/verificar-formato-rut.js"></script>
    <script src="assets/js/validar-contrasena.js"></script>
    <script src="assets/js/verificar-formato-correo.js"></script>
</head>
<body class="body bg-fondo">

<div class="container d-flex justify-content-center align-items-center min-vh-100 p-4">
    <div class="card registro-card shadow-lg pd-2" >
        <div class="card-body">

            <h3 class="text-center mb-4">Formulario de Registro</h3>

            <!-- MENSAJE DE ERROR -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form 
                action="lib/procesar_registro.php" 
                method="POST"
                onsubmit="return validarFormulario();"
            >

                <!-- NOMBRES -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Primer Nombre</label>
                        <input type="text" name="p_nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" name="s_nombre" class="form-control" required>
                    </div>
                </div>

                <!-- APELLIDOS -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" name="ap_paterno" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="ap_materno" class="form-control" required>
                    </div>
                </div>
                <!-- FECHA Y RUT -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nac" id="fecha_nac" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RUT</label>
                        <input type="text" name="rut" class="form-control"
                               oninput="formatearRUT(this)"
                               placeholder="12.345.678-9" required>
                    </div>
                </div>

                <!-- TELÉFONO Y CORREO -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                        <small id="errorCorreo" class="text-danger"></small>
                    </div>
                </div>

                <!-- DIRECCIÓN -->
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" required>
                </div>

                <!-- CONTRASEÑA -->
                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="clave" class="form-control" required>
                    <small id="errorPassword" class="text-danger"></small>
                </div>

                <!-- BOTÓN -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Registrarse
                    </button>

                    <button onclick="history.back()" type="submit" class="btn btn-danger btn-lg">
                        Regresar
                    </button>
                    
                </div>

            </form>
        </div>
    </div>
</div>

<!-- VALIDACIONES -->
<script>
function validarFormulario() {

    // Correo
    const correo = document.getElementById("correo").value;
    const errorCorreo = document.getElementById("errorCorreo");

    if (!verificarFormatoCorreo(correo)) {
        errorCorreo.textContent =
            "Solo se permiten correos @gmail.com o @hotmail.com";
        return false;
    }
    errorCorreo.textContent = "";

    // Contraseña
    const password = document.querySelector("input[name='clave']").value;
    const errorPassword = document.getElementById("errorPassword");

    if (!validarPassword(password)) {
        errorPassword.textContent =
            "Debe tener 5–15 caracteres, mayúscula, minúscula y número.";
        return false;
    }
    errorPassword.textContent = "";

    // Edad
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
