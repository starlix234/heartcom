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
    <script src="assets/js/validar-largo-texto.js"></script>
    <script src="assets/js/validar-rut.js"></script>
    <link rel="icon" href="assets/img/logo/logo_heartcom.ico">
</head>
<body class="body bg-fondo">

<!-- TÍTULO -->
<header class="text-center mt-4">
    
</header>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card registro-card shadow-lg">
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
                        <input type="text" id="p_nombre" name="p_nombre" class="form-control" oninput="validarLargoTexto('p_nombre', 3, 12, 'error_p_nombre')" required>
                        <small id="error_p_nombre" style="color:red;"></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" id="s_nombre" name="s_nombre" class="form-control" oninput="validarLargoTexto('s_nombre', 3, 12, 'error_s_nombre')" required>
                        <small id="error_s_nombre" style="color:red;"></small>
                    </div>
                </div>

                <!-- APELLIDOS -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Apellido Paterno</label>
                        <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" 
                        oninput="validarLargoTexto('ap_paterno', 2, 12, 'error_ap_paterno')" required>
                        <small id="error_ap_paterno" style="color:red;"></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" id="ap_materno" name="ap_materno" class="form-control" 
                        oninput="validarLargoTexto('ap_materno', 2, 12, 'error_ap_materno')" required>
                        <small id="error_ap_materno" style="color:red;"></small>
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
                        <input type="text" name="rut" id="rut" class="form-control" oninput="formatearRUT(this)" maxlength="12"
                               placeholder="12.345.678-9" required>
                               <small id="errorRut" class="text-danger"></small>
                    </div>
                </div>

                <!-- TELÉFONO Y CORREO -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" oninput="validarNumeros(this)" required>
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
            "Debe tener 8–15 caracteres, mayúscula, minúscula y número.";
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
    // validar largo de texto (nombres y apellidos)

    if (
        !validarLargoTexto('p_nombre', 3, 12, 'error_p_nombre') ||
        !validarLargoTexto('s_nombre', 3, 12, 'error_s_nombre') ||
        !validarLargoTexto('ap_paterno', 2, 12, 'error_ap_paterno') ||
        !validarLargoTexto('ap_materno', 2, 12, 'error_ap_materno')
    ) {

        return false;
    }
    errorCorreo.textContent = "";

    //validar teléfono (solo números)
    const valor = document.getElementById('telefono').value;

    if (!/^\d{0,9}$/.test(valor)) {
        alert('Solo se permiten números y máximo 9 caracteres');
        return false;
    }
    // RUT
    const rut = document.getElementById("rut").value;
    const errorRut = document.getElementById("errorRut");
    const rutLimpio = limpiarRut(rut);

    // 1️⃣ Bloquear secuencias repetidas
    if (tieneSecuenciaRepetida(rutLimpio)) {
        errorRut.textContent = "RUT inválido: números repetidos";
        return false;
    }

    // 2️⃣ Validar dígito verificador
    if (!validarRut(rutLimpio)) {
        errorRut.textContent = "RUT chileno inválido";
        return false;
    }

    errorRut.textContent = "";              

    return true;
}

</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
