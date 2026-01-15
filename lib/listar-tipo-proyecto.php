<?php 

require_once("conexion.php");

$sql = "SELECT id_tipo_proyecto, nombre_tipo FROM tipos_proyecto;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>