<?php
session_start();
require_once '../lib/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acceso no permitido');
}

if (
    empty($_POST['titulo']) ||
    empty($_POST['resumen']) ||
    empty($_POST['contenido']) ||
    empty($_POST['id_cate']) ||
    empty($_POST['fecha_publicacion'])
) {
    die('Faltan datos obligatorios');
}

$id_usuario = $_SESSION['id_usuario'];
$id_estado_noticia = 1;

$sql = "INSERT INTO noticias (
    titulo, resumen, contenido, id_usuario,
    id_cate, id_estado_noticia, fecha_publicacion
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

header("Location: listar.php?msg=creado");
exit;
