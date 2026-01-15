<?php

// OJO: estás dentro de /modulo-usuarios, así que la conexión está un nivel arriba
require_once '../lib/conexion.php'; // ajusta si tu conexión está en otra ruta

$sql = "
    SELECT 
    u.id_usuario,
    u.p_nombre,
    u.s_nombre,
    u.ap_paterno,
    u.ap_materno,
    u.rut,
    u.correo,
    r.nombre_rol
FROM usuarios u
JOIN roles r ON u.id_rol = r.id_rol
WHERE u.id_rol > 1
ORDER BY u.p_nombre, u.ap_paterno;
";

$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlRoles = "
   SELECT 
        u.id_usuario,
        u.p_nombre,
        u.s_nombre,
        u.ap_paterno,
        u.ap_materno,
        u.rut,
        u.correo,
        u.id_rol,           
        r.nombre_rol
    FROM usuarios u
    JOIN roles r ON u.id_rol = r.id_rol
    ORDER BY u.p_nombre, u.ap_paterno
";


$stmtRoles = $pdo->query($sqlRoles);
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
?>

