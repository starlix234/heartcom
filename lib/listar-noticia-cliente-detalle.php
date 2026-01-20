<?php
require_once "../lib/conexion.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  header("Location: noticias.php");
  exit;
}

$sql = "SELECT 
          n.id_noticia,
          n.titulo,
          n.bajada,
          n.cuerpo,
          n.imagen,
          n.fecha_publicacion,
          c.categorias_noticias
        FROM noticias n
        INNER JOIN categorias c ON n.id_cate = c.id_cate
        WHERE n.id_noticia = :id
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$n = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$n) {
  header("Location: noticias.php?err=notfound");
  exit;
}

$fecha = date("d M Y", strtotime($n['fecha_publicacion']));

// Ajuste de ruta de imagen: estás en /modulo-noticias/
// Si en BD guardas "assets/img/noticias/..." => hay que anteponer "../"
$imgSrc = null;
if (!empty($n['imagen'])) {
  $imgSrc = "../" . ltrim($n['imagen'], "/");
}
?>