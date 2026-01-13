<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

$idUsuario = (int)$_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../perfil.php");
    exit;
}

$telefono = trim($_POST['telefono'] ?? '');
$correo   = trim($_POST['correo'] ?? '');
$clave    = $_POST['clave'] ?? ''; 

if ($telefono === '' || $correo === '') {
    header("Location: ../perfil.php?error=" . urlencode("El teléfono y el correo son obligatorios."));
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../perfil.php?error=" . urlencode("Formato de correo inválido."));
    exit;
}

try {
    $sqlCheck = "SELECT id_usuario FROM usuarios WHERE correo = :correo AND id_usuario != :id";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([':correo' => $correo, ':id' => $idUsuario]);
    
    if ($stmtCheck->fetch()) {
        header("Location: ../perfil.php?error=" . urlencode("Ese correo ya está registrado por otro usuario."));
        exit;
    }

    if (!empty($clave)) {
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        
        $sqlUpdate = "UPDATE usuarios 
                      SET telefono = :telefono, correo = :correo, clave = :clave 
                      WHERE id_usuario = :id";
        $params = [
            ':telefono' => $telefono,
            ':correo'   => $correo,
            ':clave'    => $claveHash,
            ':id'       => $idUsuario
        ];
    } else {
        $sqlUpdate = "UPDATE usuarios 
                      SET telefono = :telefono, correo = :correo 
                      WHERE id_usuario = :id";
        $params = [
            ':telefono' => $telefono,
            ':correo'   => $correo,
            ':id'       => $idUsuario
        ];
    }

    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute($params);

    header("Location: ../perfil.php?success=1");

} catch (PDOException $e) {
    header("Location: ../perfil.php?error=" . urlencode("Error al actualizar: " . $e->getMessage()));
}