<?php
require_once "conexion.php";
session_start();

/* Validar rol (solo directiva / admin) 
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit;
}
    */

/*
Estados:
1 = pendiente
2 = aprobado
3 = rechazado
*/

$sql = "SELECT * FROM `solicitud` where estado='solicitado'";


$stmt = $pdo->prepare($sql);
$stmt->execute();

$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>