<?php
session_start();
require_once '../lib/conexion.php'; // para traer categorías

// Traer categorías para el select
$stmt = $pdo->query("SELECT id_cate, categorias_noticias FROM categorias ORDER BY categorias_noticias ASC");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>