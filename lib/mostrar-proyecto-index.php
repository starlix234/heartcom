<?php 
//traer la libreria de conexion
require_once 'lib/conexion.php';
$sql="select p.id_proyecto, p.nombre_proyecto , p.fecha_inicio ,p.fecha_fin ,p.descripcion from 
proyectos_barrio p order by p.fecha_inicio ASC LIMIT 4";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);





?>