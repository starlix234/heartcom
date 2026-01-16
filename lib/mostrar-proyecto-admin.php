<?php 
require_once("conexion.php");
session_start();

$sql="SELECT p.nombre_proyecto,p.descripcion, p.fecha_inicio, 
p.fecha_fin, p.responsable,p.cupo_maximo, t.nombre_tipo,e.nombre_estado 
FROM proyectos_barrio p JOIN tipos_proyecto t on p.id_tipo_proyecto = t.id_tipo_proyecto 
JOIN estados_proyecto e ON p.id_estado_proyecto = e.id_estado_proyecto;";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);




?>