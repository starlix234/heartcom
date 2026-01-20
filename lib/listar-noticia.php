<?php
// lib/listar-noticia.php
include_once __DIR__ . '/conexion.php';

$listaNoticias = []; // Variable inicial vacía

if (isset($conn)) {
    // Consulta corregida uniendo noticias, categorías y usuarios
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

    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $listaNoticias[] = $row;
        }
    }
}
?>