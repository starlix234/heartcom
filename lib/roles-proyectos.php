<?php
require_once 'conexion.php'; // aquí se crea $pdo (PDO)

$rol = null;
$nombreRol = null;

if (isset($_SESSION['id_usuario'])) {
    $idUsuario = (int) $_SESSION['id_usuario'];

    $sql = "
        SELECT u.id_rol, r.nombre_rol
        FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = :id_usuario
        
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        $rol = (int) $fila['id_rol'];         // 1, 2 o 3
        $nombreRol = $fila['nombre_rol'];     // Moderador, Jefe..., Miembro
    }
}
?>
