<?php
session_start();
require_once "../lib/conexion.php";
require_once "../lib/permisos-admin.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: noticias.php");
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  header("Location: noticias.php?err=invalid");
  exit;
}

// 1) Buscar imagen para borrarla (si corresponde)
$stmt = $pdo->prepare("SELECT imagen FROM noticias WHERE id_noticia = :id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$imagen = $stmt->fetchColumn();

// 2) Eliminar registro
$del = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = :id");
$del->bindValue(":id", $id, PDO::PARAM_INT);
$del->execute();

// 3) Borrar archivo físico (solo si está dentro de assets/img/noticias/)
if (!empty($imagen) && str_starts_with($imagen, "assets/img/noticias/")) {
  $path = __DIR__ . "/../" . $imagen;
  if (is_file($path)) {
    @unlink($path);
  }
}

header("Location: ../modulo-noticias/noticias.php?ok=deleted");
exit;
