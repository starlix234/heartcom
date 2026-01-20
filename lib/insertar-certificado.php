<?php
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Acceso no permitido.");
}

$id_certi   = $_POST['id_certi']   ?? null;
$id_usuario = $_POST['id_usuario'] ?? null;
$asunto     = $_POST['asunto']     ?? null;
$mensaje    = $_POST['mensaje']    ?? null;

// Validación básica
if (!$id_certi || !$id_usuario || !$asunto) {
    exit("Datos obligatorios incompletos.");
}

try {
    $sql = "
        INSERT INTO solicitud_certificado 
        (id_certi, id_usuario, id_estado, asunto, mensaje)
        VALUES (?, ?, 1, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $id_certi,
        $id_usuario,
        $asunto,
        $mensaje
    ]);

header("Location: ../modulo-reservas/solicitudes.php");



} catch (PDOException $e) {
    echo "Error al registrar la solicitud";
}
