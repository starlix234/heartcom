<?php
session_start();
require_once "../lib/conexion.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: noticias.php"); exit; }

// Traer noticia (OJO: el campo es cuerpo)
$sql = "SELECT 
          n.id_noticia,
          n.titulo,
          n.bajada,
          n.cuerpo,
          n.imagen,
          n.fecha_publicacion,
          n.id_cate
        FROM noticias n
        WHERE n.id_noticia = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$noticia) { header("Location:../modulo-noticias/noticias.php"); exit; }

// Categorías
$cat = $pdo->query("SELECT id_cate, categorias_noticias FROM categorias ORDER BY categorias_noticias ASC");
$categorias = $cat->fetchAll(PDO::FETCH_ASSOC);

$ok  = $_GET['ok']  ?? null;
$err = $_GET['err'] ?? null;
?>