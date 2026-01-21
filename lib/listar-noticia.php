<?php
// lib/listar-noticia.php
require_once __DIR__ . '/conexion.php';

$listaNoticias = [];

if (!isset($pdo)) {
    die("Error: no existe la conexión PDO ($pdo).");
}

$sql = "SELECT
            n.id_noticia,
            n.titulo,
            n.bajada,
            n.cuerpo,
            n.imagen,
            n.fecha_publicacion,
            c.categorias_noticias AS categoria,
            u.p_nombre,
            u.ap_paterno
        FROM noticias n
        LEFT JOIN categorias c ON n.id_cate = c.id_cate
        LEFT JOIN usuarios u ON n.id_usuario = u.id_usuario
        ORDER BY n.fecha_publicacion DESC";

try {
    $stmt = $pdo->query($sql);
    $listaNoticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error SQL: " . $e->getMessage());
}
?>