<?php
require_once '../lib/conexion.php';

// valores simulados (pueden venir de sesión)
$id_usuario = 1;
$id_estado_noticia = 1; // 1 = publicada

$sql = "INSERT INTO noticias (
            titulo,
            resumen,
            contenido,
            id_usuario,
            id_cate,
            id_estado_noticia,
            fecha_publicacion
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['titulo'],
    $_POST['resumen'],
    $_POST['contenido'],
    $id_usuario,
    $_POST['id_cate'],
    $id_estado_noticia,
    $_POST['fecha_publicacion']
]);

header("Location: listar.php");
exit;
