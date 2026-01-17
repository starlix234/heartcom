<?php
require_once("../lib/conexion.php");
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$accion = $_GET['accion'] ?? '';

if ($id <= 0) {
  header("Location: proyectos.php?msg=" . urlencode("Proyecto inválido."));
  exit;
}

$stmt = $pdo->prepare("
  SELECT p.*, tp.nombre_tipo, ep.nombre_estado
  FROM proyectos_barrio p
  JOIN tipos_proyecto tp ON p.id_tipo_proyecto = tp.id_tipo_proyecto
  JOIN estados_proyecto ep ON p.id_estado_proyecto = ep.id_estado_proyecto
  WHERE p.id_proyecto = ?
  LIMIT 1
");
$stmt->execute([$id]);
$proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$proyecto) {
  header("Location: proyectos.php?msg=" . urlencode("Proyecto no encontrado."));
  exit;
}

$nombre = htmlspecialchars($proyecto['nombre_proyecto'] ?? '');
$desc   = htmlspecialchars($proyecto['descripcion'] ?? '');
$ini    = htmlspecialchars($proyecto['fecha_inicio'] ?? '');
$fin    = htmlspecialchars($proyecto['fecha_fin'] ?? '');
$resp   = htmlspecialchars($proyecto['responsable'] ?? '');
$cupo   = htmlspecialchars($proyecto['cupo_maximo'] ?? '');
$tipo   = htmlspecialchars($proyecto['nombre_tipo'] ?? '');
$estado = htmlspecialchars($proyecto['nombre_estado'] ?? '');
?>
