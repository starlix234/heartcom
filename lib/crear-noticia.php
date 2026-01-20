<?php
require_once '../lib/conexion.php';

// categorias
$stmt = $pdo->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>