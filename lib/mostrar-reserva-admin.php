<?php 
include 'conexion.php';
//session_start();

// Tu consulta
$sql = "SELECT 
            r.id_reserva,
            r.Fecha_ini, 
            r.Fecha_fin, 
            r.asunto, 
            r.motivo, 
            t.tipo, 
            e.estado, 
            CONCAT_WS(' ', u.p_nombre, u.s_nombre, u.ap_paterno, u.ap_materno) AS nombre_completo 
        FROM reservas r 
        JOIN tipo_reserva t 
            ON r.id_tipo = t.id_tipo 
        JOIN estado_reserva e 
            ON r.id_estado_reserva = e.id_estado_reserva 
        JOIN usuarios u 
            ON r.id_usuario = u.id_usuario";

// Ejecutar consulta
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>