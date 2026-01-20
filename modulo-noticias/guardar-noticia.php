<?php
require_once '../lib/conexion.php';

// valores simulados (pueden venir de sesión)
$id_usuario = 1;
$id_estado_noticia = 1; // 1 = publicada

// unir fecha + hora (formato 24 hrs)
$fecha = $_POST['fecha_publicacion'];
$hora  = $_POST['hora_publicacion'];
$fecha_hora = $fecha . ' ' . $hora . ':00';

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
    $fecha_hora
]);

// ✅ REDIRECCIÓN CORRECTA
header("Location: listar.php");
exit;
