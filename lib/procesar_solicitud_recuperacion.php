<?php
session_start();
require_once("conexion.php");
require_once("funciones_auth.php"); 
// Nota: funciones_auth.php debe contener la función 'enviarCorreoCodigo'
// que es la misma que usa tu login.

$rut = $_POST['rut'] ?? '';

if (empty($rut)) {
    header("Location: ../recuperar.php?error=" . urlencode("Ingrese su RUT."));
    exit;
}

// 1. Buscar usuario
$usuario = obtenerUsuarioPorRut($rut);

if (!$usuario) {
    header("Location: ../recuperar.php?error=" . urlencode("RUT no encontrado."));
    exit;
}

// 2. Generar código tipo RECUPERAR
// Asegúrate de haber hecho el ALTER TABLE en la base de datos para aceptar 'RECUPERAR'
$codigo = crearCodigoMFA($usuario['id_usuario'], 'RECUPERAR');

// 3. Enviar correo USANDO LA MISMA FUNCIÓN QUE EL LOGIN
// Esta es la clave: usamos la función que ya sabes que funciona.
try {
    // Intentamos enviar el correo
    $enviado = enviarCorreoCodigo($usuario['correo'], $codigo);
    
    // Si falla el envío, NO lanzamos error, solo lo ignoramos
    // para permitir que pases a escribir el código manualmente.
    
} catch (Exception $e) {
    // No hacemos nada, dejamos que el script continúe
}

// 4. Guardar ID temporalmente en sesión para la verificación
$_SESSION['id_recuperacion'] = $usuario['id_usuario'];

// 5. ¡AQUÍ ESTÁ LA CLAVE! 
// Siempre redirigimos a verificar, haya funcionado el correo o no.
header("Location: ../verificar_recuperacion.php");
exit;