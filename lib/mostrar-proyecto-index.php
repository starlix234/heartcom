<?php
// lib/mostrar-proyecto-index.php
include_once __DIR__ . '/conexion.php';

$proyecto = []; // Variable inicial vacía

// Verificamos conexión
if (isset($conn)) {
    // Consulta corregida para tu tabla 'proyectos_barrio'
    $sql = "SELECT 
                p.id_proyecto,
                p.nombre_proyecto,
                p.descripcion,
                p.fecha_inicio,
                p.fecha_fin,
                p.cupo_maximo,
                p.responsable,
                e.nombre_estado,
                t.nombre_tipo
            FROM proyectos_barrio p
            LEFT JOIN estados_proyecto e ON p.id_estado_proyecto = e.id_estado_proyecto
            LEFT JOIN tipos_proyecto t ON p.id_tipo_proyecto = t.id_tipo_proyecto
            WHERE e.nombre_estado NOT IN ('Cancelado', 'Rechazado')
            ORDER BY p.fecha_inicio DESC"; // Ordenar por fecha más reciente

    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $proyecto[] = $row;
        }
    }
}
?>