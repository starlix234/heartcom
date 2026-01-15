<?php
require_once("conexion.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['guardar'])) {
    return;
}

$nombre_proyecto       = $_POST['nombre_proyecto'] ?? '';
$descripcion           = $_POST['descripcion'] ?? '';
$fecha_ini             = $_POST['fecha_inicio'] ?? '';
$fecha_fin             = $_POST['fecha_fin'] ?? null;
$id_tipo_pr            = $_POST['id_tipo_proyecto'] ?? '';
$responsable           = $_SESSION['nombre_usuario'] . " " . $_SESSION['p_nombre'] . " " . $_SESSION['ap_paterno']." " . $_SESSION['ap_materno'];
$presupuesto_estimado  = $_POST['presupuesto_estimado'] ?? 0;
$direccion_proyecto    = $_POST['direccion_proyecto'] ?? '';
$cupo_maximo           = $_POST['cupo_maximo'] ?? 0;



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
    $responsable,
    $presupuesto_estimado,
    0,
    $direccion_proyecto,
    $cupo_maximo
]);

header("Location: ../modulo-proyecto/mostrar-proyecto.php?mensaje=" . urlencode("Proyecto guardado exitosamente."));
exit;
