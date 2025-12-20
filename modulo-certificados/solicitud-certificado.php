<?php
require("lib/leer-tipo-certificado.php"); 

// Asegúrate de que la sesión tiene el ID del usuario
if (!isset($_SESSION['id_usuario'])) {
    // Redirigir o manejar el error si no hay un usuario en sesión
    header("Location: login.php"); // Cambia a la página de inicio de sesión o muestra un mensaje adecuado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilo-formulario.css">
    <title>Solicitar Certificado</title>
</head>
<body>

<section class="contenido">
<h1>Solicitar Certificado</h1>

<form action="lib/insertar-certificado.php" class="formulario-general" method="post">   

    <label for="asunto">asunto</label>
    <input type="text" name="asunto" class="input-form" id="asunto">

    <label for="id_certi">Seleccione un certificado:</label>
    <select name="id_certi" id="id_certi" required>
        <option value="">Seleccione un certificado</option>
        <?php foreach ($tiposCertificados as $cert): ?>
            <option value="<?= htmlspecialchars($cert['id_certi']) ?>">
                <?= htmlspecialchars($cert['nombre_certificado']) ?>
            </option>
        <?php endforeach; ?>
    </select>
     <label for="mensaje">Motivo de la Solicitud:</label>
    <textarea 
        name="mensaje" 
        id="mensaje" 
        rows="4" 
        cols="50"
        placeholder="Ingrese el motivo del porque desea solicitar este certificado o permiso"
        required
        class="caja-texto"
    ></textarea>

    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo htmlspecialchars($_SESSION['id_usuario']); ?>" required readonly>

    <input type="submit" class="boton" value="Enviar Solicitud">
</form>


</section>

</body>
</html>