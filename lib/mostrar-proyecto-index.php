<?php
require_once __DIR__ . "/../lib/conexion.php"; // ajusta si tu ruta cambia

$sql = "
 SELECT p.id_proyecto,p.nombre_proyecto,p.descripcion, p.fecha_inicio, 
p.fecha_fin, p.responsable,p.cupo_maximo, t.nombre_tipo FROM proyectos_barrio p JOIN tipos_proyecto t on p.id_tipo_proyecto = t.id_tipo_proyecto WHERE p.id_estado_proyecto=5
LIMIT :limite
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limite', 4, PDO::PARAM_INT);
$stmt->execute();

$proyectosRecientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>