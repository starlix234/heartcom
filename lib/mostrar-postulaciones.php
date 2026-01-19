<?php
// ../lib/mostrar-postulaciones.php
require_once(__DIR__ . "/conexion.php");

$sql = "SELECT p.id_postulacion, p.fecha_postulacion, p.id_estado_postulacion, ep.nombre_estado AS estado_postulacion, p.observacion_admin, p.fecha_respuesta, p.id_estado_postulacion, pb.id_proyecto, pb.nombre_proyecto, pb.cupo_maximo, u.id_usuario, CONCAT_WS(' ', u.p_nombre, u.s_nombre, u.ap_paterno, u.ap_materno) AS postulante, COALESCE(a.aceptados, 0) AS cupos_usados FROM postulaciones_proyecto p JOIN proyectos_barrio pb ON pb.id_proyecto = p.id_proyecto JOIN estados_postulacion ep ON ep.id_estado_postulacion = p.id_estado_postulacion JOIN usuarios u ON u.id_usuario = p.id_usuario LEFT JOIN ( SELECT id_proyecto, COUNT(*) AS aceptados FROM postulaciones_proyecto WHERE id_estado_postulacion = 2 GROUP BY id_proyecto ) a ON a.id_proyecto = p.id_proyecto ORDER BY p.fecha_postulacion DESC;
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>