<?php
session_start();
require_once __DIR__ . '/conexion.php'; 

// 1. Verificar Login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php?error=" . urlencode("Debes iniciar sesión."));
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si intentan entrar directo, los devolvemos al panel
    header("Location: ../modulo-reservas/reservas.php");
    exit;
}

$id_tipo    = $_POST['id_tipo']   ?? null;
$fecha_ini  = $_POST['fecha_ini'] ?? null;
$fecha_fin  = $_POST['fecha_fin'] ?? null;
$asunto     = $_POST['asunto']    ?? null;
$motivo     = $_POST['motivo']    ?? null;
$id_estado_reserva = 1; // 1 = en proceso

// ==========================================
// VALIDACIONES (Redirigen con error si fallan)
// ==========================================

// A) Campos vacíos
if (empty($id_tipo) || empty($fecha_ini) || empty($fecha_fin) || empty($asunto)) {
    header("Location: ../modulo-reservas/reservas.php?error=" . urlencode("Faltan datos obligatorios."));
    exit;
}

// B) Coherencia de fechas (Fin antes que Inicio)
if ($fecha_fin < $fecha_ini) {
    header("Location: ../modulo-reservas/reservas.php?error=" . urlencode("La fecha de término no puede ser antes que la de inicio."));
    exit;
}

// C) FECHA PASADA (No permitir reservar ayer o días anteriores)
$fecha_actual = date('Y-m-d'); // Fecha de hoy del servidor

if ($fecha_ini < $fecha_actual) {
    // AQUÍ ESTÁ EL CAMBIO: Redirige con mensaje de error
    header("Location: ../modulo-reservas/reservas.php?error=" . urlencode("Error: No puedes reservar en una fecha pasada (" . date("d/m/Y", strtotime($fecha_ini)) . ")."));
    exit;
}

// ==========================================
// INSERTAR EN BASE DE DATOS
// ==========================================

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
        ':usuario' => $id_usuario
    ]);

    // ÉXITO: Redirigir con mensaje verde (msg)
    header("Location: ../modulo-reservas/reservas.php?msg=" . urlencode("¡Reserva enviada con éxito! Espera la aprobación."));
    exit;

} catch (PDOException $e) {
    // Error de base de datos
    header("Location: ../modulo-reservas/reservas.php?error=" . urlencode("Error en el sistema al guardar. Intente más tarde."));
    exit;
}
?>