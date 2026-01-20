<?php
//session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/heartcom/lib/conexion.php';


// Traer noticias
$sql = "SELECT 
          n.id_noticia,
          n.titulo,
          n.bajada,
          n.fecha_publicacion,
          c.categorias_noticias
        FROM noticias n
        INNER JOIN categorias c ON n.id_cate = c.id_cate
        ORDER BY n.fecha_publicacion DESC, n.id_noticia DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>