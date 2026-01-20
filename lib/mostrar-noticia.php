<?php
require_once 'conexion.php';

$sql = "SELECT 
            n.id_noticia,
            n.titulo,
            n.fecha_publicacion,
            c.categorias_noticias
        FROM noticias n
        INNER JOIN categorias c ON n.id_cate = c.id_cate
        ORDER BY n.id_noticia DESC";  

$stmt = $pdo->prepare($sql);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>