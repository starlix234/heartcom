<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'conexion.php';

$usuario_id = $_SESSION['id_usuario'] ?? null;;

try {
    $stmt = $pdo->prepare('SELECT pb.nombre_proyecto, pb.descripcion, pb.fecha_inicio, 
    pb.fecha_fin, pb.responsable ,pp.fecha_postulacion,e.nombre_estado, 
    pp.fecha_respuesta ,pp.observacion_admin FROM postulaciones_proyecto 
    pp JOIN proyectos_barrio pb ON pp.id_proyecto = pb.id_proyecto 
    JOIN estados_postulacion e on pp.id_estado_postulacion=e.id_estado_postulacion
    WHERE pp.id_usuario = :id_usuario
    ');
    $stmt->execute(['id_usuario' => $usuario_id]);
    $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las postulaciones: " . $e->getMessage());
}

?>