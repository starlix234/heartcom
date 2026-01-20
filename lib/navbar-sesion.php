<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/conexion.php'; // ajusta si la ruta cambia

$base = $base ?? ""; // setéalo en cada página: "" o "../" etc.

$rol = null;
$nombreRol = null;

if (isset($_SESSION['id_usuario'])) {
    $idUsuario = (int) $_SESSION['id_usuario'];

    $sql = "
        SELECT u.id_rol, r.nombre_rol
        FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = :id_usuario
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        $rol = (int) $fila['id_rol'];       // 1, 2, 3
        $nombreRol = $fila['nombre_rol'];   // Admin, Moderador, Vecino, etc.
    }
}

// Si no hay sesión o no encontró rol, lo tratamos como visitante/vecino:
$rol = $rol ?? 3;

function can($rol, array $allowed): bool {
    return in_array((int)$rol, $allowed, true);
}
?>