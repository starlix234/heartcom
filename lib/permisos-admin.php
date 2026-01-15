<?php
session_start();
require_once '../lib/conexion.php'; // ajusta la ruta si es otra

// 1️⃣ Debe existir sesión
if (empty($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$idUsuario = (int) $_SESSION['id_usuario'];

// 2️⃣ Consultar el rol REAL del usuario en la BD
$sql = "SELECT id_rol FROM usuarios WHERE id_usuario = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no existe el usuario → afuera igual
if (!$usuario) {
    header("Location: ../login.php");
    exit;
}

$idRol = (int)$usuario['id_rol'];

// 3️⃣ Solo permitir rol 1 (Moderador)
if ($idRol !== 1) {
    header("Location: ../panel.php?error=" . urlencode("Acceso denegado: solo moderadores."));
    exit;
}

// 👉 Si llegó hasta aquí, es Moderador y puede ver la página

?>