<?php
session_start();
require_once __DIR__ . '/conexion.php'; // ajusta la ruta si es otra

// ⚠️ Asegúrate de que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión para ver tus reservas.");
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta con la que tú misma escribiste
$sql = "SELECT 
            e.estado,
            r.Fecha_ini,
            r.Fecha_fin,
            r.asunto,
            r.motivo,
            t.tipo
        FROM estado_reserva e
        JOIN reservas r ON e.id_estado_reserva = r.id_estado_reserva
        JOIN tipo_reserva t ON t.id_tipo = r.id_tipo
        WHERE r.id_usuario = :id_usuario
        ORDER BY r.Fecha_ini DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id_usuario' => $id_usuario]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>