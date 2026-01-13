<?php
// SIEMPRE lo primero
session_start();

// incluye la conexión (ajusta la ruta si está en otro lado)
require_once __DIR__ . '/conexion.php';

// =======================
// 1. Verificar login
// =======================

// Si aún no tienes login hecho, para probar puedes DEJAR HARDCODEADO:
/// $id_usuario = 8; // <-- SOLO PARA PRUEBA
// pero lo ideal es usar la sesión:
if (!isset($_SESSION['id_usuario'])) {
    // Mientras tanto puedes hacer esto para ver el error más claro:
    // die("No hay usuario en sesión. Inicia sesión primero.");
    
    // O redirigir al login:
    // header("Location: ../login.php");
    // exit;

    // Para que no reviente ahora, voy a dejar un valor de prueba:
    $id_usuario = 8; // <-- quita esto cuando tengas login
} else {
    $id_usuario = $_SESSION['id_usuario'];
}

// =======================
// 2. Recibir datos del formulario
// =======================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso inválido.");
}

$id_tipo    = $_POST['id_tipo']   ?? null;
$fecha_ini  = $_POST['fecha_ini'] ?? null;
$fecha_fin  = $_POST['fecha_fin'] ?? null;
$asunto     = $_POST['asunto']    ?? null;
$motivo     = $_POST['motivo']    ?? null;

// estado 1 = "en proceso"
$id_estado_reserva = 1;

// Validaciones básicas
if (empty($id_tipo) || empty($fecha_ini) || empty($fecha_fin) || empty($asunto)) {
    die("Faltan datos obligatorios.");
}

if ($fecha_fin < $fecha_ini) {
    die("La fecha fin no puede ser menor que la fecha inicio.");
}

// =======================
// 3. Insert en la BD
// =======================

try {
    $sql = "INSERT INTO reservas
            (id_estado_reserva, id_tipo, Fecha_ini, Fecha_fin, asunto, motivo, id_usuario)
            VALUES (:estado, :tipo, :fi, :ff, :asunto, :motivo, :usuario)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':estado'  => $id_estado_reserva,
        ':tipo'    => $id_tipo,
        ':fi'      => $fecha_ini,
        ':ff'      => $fecha_fin,
        ':asunto'  => $asunto,
        ':motivo'  => $motivo,
        ':usuario' => $id_usuario,
    ]);

    // Redirigir después de insertar
    header("Location: ../modulo-reservas/panel-reservas.php");// ruta temporal
    exit;

} catch (PDOException $e) {
    // Para debug:
    echo "Error al guardar la reserva: " . $e->getMessage();
}
?>