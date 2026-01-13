<?php
require 'conexion.php';

$sql = "SELECT id_tipo, tipo FROM tipo_reserva";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
