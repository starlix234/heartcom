<?php
session_start();
require_once 'lib/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = (int)$_SESSION['id_usuario'];

$sql = "SELECT p_nombre, ap_paterno, telefono, correo FROM usuarios WHERE id_usuario = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>