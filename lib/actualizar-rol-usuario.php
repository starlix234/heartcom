<?php
session_start();
require_once 'conexion.php';   // aquí tienes tu $pdo (PDO)

// ✅ 1. Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

// ✅ 2. (Opcional) Verificar que tenga permisos para cambiar roles
// Ajusta el número de rol que consideres "administrador"
if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] != 1) {
    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode("No tienes permisos para cambiar roles."));
    exit;
}

// ✅ 3. Verificar que venga por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode("Método no permitido."));
    exit;
}

// ✅ 4. Capturar y validar datos
$idUsuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
$idRol     = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);

if (!$idUsuario || !$idRol) {
    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode("Datos inválidos para actualizar el rol."));
    exit;
}

// (Opcional) Evitar que alguien se cambie su propio rol desde aquí
if (isset($_SESSION['id_usuario']) && $idUsuario == $_SESSION['id_usuario']) {
    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode("No puedes cambiar tu propio rol desde este módulo."));
    exit;
}

try {
    // ✅ 5. Verificar que el rol exista
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM roles WHERE id_rol = :id_rol");
    $stmt->bindValue(':id_rol', $idRol, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetchColumn() == 0) {
        header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode("El rol seleccionado no existe."));
        exit;
    }

    // ✅ 6. Actualizar rol del usuario
    $sqlUpdate = "
        UPDATE usuarios
        SET id_rol = :id_rol
        WHERE id_usuario = :id_usuario
    ";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindValue(':id_rol', $idRol, PDO::PARAM_INT);
    $stmtUpdate->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmtUpdate->execute();

    // Mensaje de salida
    $msg = ($stmtUpdate->rowCount() > 0)
        ? "Rol actualizado correctamente."
        : "No hubo cambios (el usuario ya tenía ese rol).";

    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?msg=" . urlencode($msg));
    exit;

} catch (PDOException $e) {
    $error = "Error al actualizar el rol: " . $e->getMessage();
    header("Location: ../modulo-usuarios/administrar-rol-usuarios.php?error=" . urlencode($error));
    exit;
}
?>