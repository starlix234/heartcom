<?php
require_once("conexion.php");

$sql = "SELECT id_certi, nombre_certificado FROM tipos_certificados";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$tiposCertificados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>