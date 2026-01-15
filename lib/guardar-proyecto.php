<?php 
session_start();
require_once("conexion.php");

$nombre_proyecto= $_POST['nombre_proyecto'];
$descripcion=$_POST['descripcion'];
$fecha_ini=$_POST['fecha_inicio'];
$fecha_fin=$_POST['fecha_fin'];
$id_estadp_pr=$_POST['id_estado_proyecto'];
$id_tipo_pr=$_POST['id_tipo_proyecto'];
$responsable=$_POST['responsable'];
$presupuesto_estimado=$_POST['presupuesto_estimado'];
$presupuesto_utilizado=$_POST['presupuesto_utilizado'];
$fecha_creacion=$_POST['fecha_creacion'];
$fecha_actualizacion['fecha_actualizacion'];
$cupos_maximo['cupos_maximo'];

$sql=$pdo=prepare("INSERT INTO proyectos_barrio (
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
) VALUES (?,?,?,?,?,?,?,?,?,?,?)");


$stmt->execute([$nombre_proyecto,
    $descripcion,
    $fecha_ini,
    $fecha_fin,
    $id_estadp_pr,
    $id_tipo_pr,
    $responsable,
    $presupuesto_estimado,
    $presupuesto_utilizado,
    $fecha_creacion,
    $fecha_actualizacion,
    $cupos_maximo
]); 



?>