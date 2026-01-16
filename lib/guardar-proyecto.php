<?php
require_once("conexion.php");
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("Usuario no autenticado");
}

$id_usuario = $_SESSION['id_usuario'];

/* ===== OBTENER NOMBRE COMPLETO ===== */
$stmtUser = $pdo->prepare("
    SELECT CONCAT_WS(' ',
        p_nombre,
        s_nombre,
        ap_paterno,
        ap_materno
    )
    FROM usuarios
    WHERE id_usuario = ?
");
$stmtUser->execute([$id_usuario]);

$responsable = $stmtUser->fetchColumn();

if (!$responsable) {
    die("No se pudo obtener el nombre del usuario");
}

/* ===== VALIDAR POST ===== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['guardar'])) {
    return;
}

/* ===== DATOS FORMULARIO ===== */
$nombre_proyecto      = $_POST['nombre_proyecto'] ?? '';
$descripcion          = $_POST['descripcion'] ?? '';
$fecha_ini            = $_POST['fecha_inicio'] ?? '';
$fecha_fin            = $_POST['fecha_fin'] ?? null;
$id_tipo_pr           = $_POST['id_tipo_proyecto'] ?? '';
$presupuesto_estimado = $_POST['presupuesto_estimado'] ?? 0;
$direccion_proyecto   = $_POST['direccion_proyecto'] ?? '';
$cupo_maximo          = $_POST['cupo_maximo'] ?? 0;

/* ===== INSERT (estado siempre 1) ===== */
$sql = "INSERT INTO proyectos_barrio (
    nombre_proyecto,
    descripcion,
    fecha_inicio,
    fecha_fin,
    id_estado_proyecto,
    id_tipo_proyecto,
    responsable,
    presupuesto_estimado,
    presupuesto_utilizado,
    direccion_proyecto,
    cupo_maximo
) VALUES (?,?,?,?,1,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $nombre_proyecto,
    $descripcion,
    $fecha_ini,
    $fecha_fin,
    $id_tipo_pr,
    $responsable,   // 👈 NOMBRE DEL USUARIO
    $presupuesto_estimado,
    0,
    $direccion_proyecto,
    $cupo_maximo
]);

header("Location: ../modulo-proyecto/mostrar-proyecto.php?mensaje=" . urlencode("Proyecto guardado exitosamente."));
exit;

