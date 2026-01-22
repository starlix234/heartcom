<?php
// lib/procesar_recuperacion.php
session_start();
require_once("conexion.php");
require_once("funciones_auth.php");

// 1. Recibir el RUT del formulario
$rut = isset($_POST['rut']) ? trim($_POST['rut']) : '';

if ($rut === '') {
    header("Location: ../recuperar.php?error=" . urlencode("Debes ingresar tu RUT."));
    exit;
}

// 2. Buscar al usuario (Usando tu función existente en funciones_auth.php)
// Asumo que esta función existe porque la usas en el login
$usuario = obtenerUsuarioPorRut($rut);

if (!$usuario) {
    // Por seguridad, puedes decir "RUT no encontrado" o un mensaje genérico
    header("Location: ../recuperar.php?error=" . urlencode("El RUT no se encuentra registrado."));
    exit;
}

// 3. Generar el código (Adaptado a tu lógica de MFA)
$id_usuario = $usuario['id_usuario'];
$correo     = $usuario['correo'];

// Llamamos a crearCodigoMFA pasando el segundo parámetro 'RECUPERAR' 
// para que coincida con lo que espera tu procesar_codigo_recuperacion.php
$codigo = crearCodigoMFA($id_usuario, 'RECUPERAR'); 

// 4. Enviar el correo
$asunto = "Recuperar Contraseña - HeartCom";
$mensaje = "Hola " . $usuario['p_nombre'] . ",\n\n";
$mensaje .= "Has solicitado recuperar tu contraseña.\n";
$mensaje .= "Tu código de verificación es: " . $codigo . "\n\n";
$mensaje .= "Si no fuiste tú, ignora este mensaje.";

// Encabezados simples para texto plano
$headers = "From: no-reply@heartcom.cl" . "\r\n" .
           "Reply-To: no-reply@heartcom.cl" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Intentar enviar
$enviado = mail($correo, $asunto, $mensaje, $headers);

if (!$enviado) {
    header("Location: ../recuperar.php?error=" . urlencode("Error al enviar el correo. Intente más tarde."));
    exit;
}

// 5. Guardar en sesión y redirigir
// Esto es CRÍTICO: procesar_codigo_recuperacion.php busca $_SESSION['id_recuperacion']
$_SESSION['id_recuperacion'] = $id_usuario;

// Redirigimos a la vista donde se pone el código
header("Location: ../verificar_recuperacion.php");
exit;
?>