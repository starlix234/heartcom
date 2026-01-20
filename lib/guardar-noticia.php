<?php
session_start();
require_once 'conexion.php';

// Verificación de seguridad: Si no vienen del formulario, fuera.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../modulo-noticias/agregar-noticia.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'] ?? 1;

$titulo = trim($_POST['titulo'] ?? '');
$bajada = trim($_POST['bajada'] ?? '');
$cuerpo = trim($_POST['cuerpo'] ?? '');
$idCate = (int)($_POST['id_cate'] ?? 0);

// Validación mínima (evita inserts rotos)
if ($titulo === '' || $cuerpo === '' || $idCate <= 0) {
    header("Location: ../modulo-noticias/agregar-noticia.php?msg=Faltan_datos");
    exit;
}

// --- PROCESAR IMAGEN ---
$rutaParaBD = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $carpeta = "../assets/img/noticias/";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombreArchivo = time() . "_" . basename($_FILES['foto']['name']);
    $rutaFinal = $carpeta . $nombreArchivo;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFinal)) {
        $rutaParaBD = "assets/img/noticias/" . $nombreArchivo;
    }
}

// --- GUARDAR EN BASE DE DATOS ---
try {
    // Ahora incluye id_cate
    $sql = "INSERT INTO noticias (titulo, bajada, cuerpo, imagen, fecha_publicacion, id_usuario, id_cate)
            VALUES (:titulo, :bajada, :cuerpo, :imagen, NOW(), :id_usuario, :id_cate)";

    $stmt = $pdo->prepare($sql);

    $ok = $stmt->execute([
        ':titulo'     => $titulo,
        ':bajada'     => ($bajada !== '' ? $bajada : null),
        ':cuerpo'     => $cuerpo,
        ':imagen'     => $rutaParaBD,
        ':id_usuario' => $idUsuario,
        ':id_cate'    => $idCate
    ]);

    if ($ok) {
        header("Location: ../ver-noticia.php?msg=Publicado_con_exito");
        exit;
    }

    // Si por alguna razón no insertó, rebotamos igual
    header("Location: ../modulo-noticias/agregar-noticia.php?msg=No_se_pudo_guardar");
    exit;

} catch (PDOException $e) {
    echo "<h1>Error al guardar</h1>";
    echo "Detalle: " . $e->getMessage();
}
?>
