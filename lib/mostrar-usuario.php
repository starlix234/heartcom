<?php

// Estás en /modulo-usuarios, la conexión está un nivel arriba
require_once '../lib/conexion.php';

// 🔹 1) Traer usuarios con su rol actual
$sqlUsuarios = "
    SELECT 
        u.id_usuario,
        u.p_nombre,
        u.s_nombre,
        u.ap_paterno,
        u.ap_materno,
        u.rut,
        u.correo,
        u.id_rol,          -- 👈 IMPORTANTE: esto antes no lo estabas trayendo
        r.nombre_rol
    FROM usuarios u
    JOIN roles r ON u.id_rol = r.id_rol
    WHERE u.id_rol > 1          -- si quieres ocultar al súper admin, ok, déjalo
    ORDER BY u.p_nombre, u.ap_paterno
";

$stmt = $pdo->query($sqlUsuarios);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 🔹 2) Traer listado de roles disponibles
$sqlRoles = "
    SELECT 
        id_rol,
        nombre_rol
    FROM roles
    WHERE id_rol > 1            -- mismo criterio: no mostrar rol admin si no quieres
    ORDER BY nombre_rol
";

$stmtRoles = $pdo->query($sqlRoles);
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
?>