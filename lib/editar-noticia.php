<?php
session_start();
require_once "../lib/conexion.php";
require_once "../lib/permisos-admin.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: noticias.php");
  exit;
}

$id = isset($_POST['id_noticia']) ? (int)$_POST['id_noticia'] : 0;
if ($id <= 0) {
  header("Location: noticias.php?err=invalid");
  exit;
}

$titulo = trim($_POST['titulo'] ?? '');
$bajada = trim($_POST['bajada'] ?? '');
$cuerpo = trim($_POST['cuerpo'] ?? '');
$id_cate = (int)($_POST['id_cate'] ?? 0);
$fecha_publicacion = $_POST['fecha_publicacion'] ?? null;

if ($titulo === '' || $cuerpo === '' || $id_cate <= 0) {
  header("Location: editar-noticia-detalle.php?id=$id&err=campos");
  exit;
}

// Imagen actual
$stmt = $pdo->prepare("SELECT imagen FROM noticias WHERE id_noticia = :id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$imagenAnterior = $stmt->fetchColumn();

$nuevaRutaBD = null;

// Si subieron imagen, procesar
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {

  if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    header("Location: editar-noticia-detalle.php?id=$id&err=file");
    exit;
  }

  $maxSize = 3 * 1024 * 1024; // 3MB (avif a veces pesa más)
  if ($_FILES['imagen']['size'] > $maxSize) {
    header("Location: editar-noticia-detalle.php?id=$id&err=size");
    exit;
  }

  $tmp = $_FILES['imagen']['tmp_name'];
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $tmp);
  finfo_close($finfo);

  $allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/avif' => 'avif'
  ];

  if (!isset($allowed[$mime])) {
    header("Location: editar-noticia-detalle.php?id=$id&err=type");
    exit;
  }

  $ext = $allowed[$mime];

  // Tu carpeta real (según tu BD)
  $destDir = __DIR__ . "/../assets/img/noticias";
  if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
  }

  $filename = time() . "_" . bin2hex(random_bytes(10)) . "." . $ext;
  $destPath = $destDir . "/" . $filename;

  if (!move_uploaded_file($tmp, $destPath)) {
    header("Location: editar-noticia-detalle.php?id=$id&err=upload");
    exit;
  }

  // Ruta que se guarda en BD (igual a las que ya tienes)
  $nuevaRutaBD = "assets/img/noticias/" . $filename;

  // Borrar anterior solo si está dentro de esa carpeta (para no borrar cualquier cosa)
  if (!empty($imagenAnterior) && str_starts_with($imagenAnterior, "assets/img/noticias/")) {
    $oldPath = __DIR__ . "/../" . $imagenAnterior;
    if (is_file($oldPath)) @unlink($oldPath);
  }
}

// UPDATE (con o sin imagen)
if ($nuevaRutaBD) {
  $sql = "UPDATE noticias
          SET titulo = :titulo,
              bajada = :bajada,
              cuerpo = :cuerpo,
              id_cate = :id_cate,
              fecha_publicacion = :fecha_publicacion,
              imagen = :imagen
          WHERE id_noticia = :id";
} else {
  $sql = "UPDATE noticias
          SET titulo = :titulo,
              bajada = :bajada,
              cuerpo = :cuerpo,
              id_cate = :id_cate,
              fecha_publicacion = :fecha_publicacion
          WHERE id_noticia = :id";
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":titulo", $titulo, PDO::PARAM_STR);
$stmt->bindValue(":bajada", $bajada, PDO::PARAM_STR);
$stmt->bindValue(":cuerpo", $cuerpo, PDO::PARAM_STR);
$stmt->bindValue(":id_cate", $id_cate, PDO::PARAM_INT);
$stmt->bindValue(":fecha_publicacion", $fecha_publicacion ?: null, PDO::PARAM_STR);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);

if ($nuevaRutaBD) {
  $stmt->bindValue(":imagen", $nuevaRutaBD, PDO::PARAM_STR);
}

$stmt->execute();

header("Location: ../modulo-noticias/editar-noticia-detalle.php?id=$id&ok=saved");
exit;
