<?php
require_once __DIR__ . "/conexion.php"; // ajusta si tu ruta cambia

try {
    $sql = "SELECT p.id_proyecto, p.nombre_proyecto, p.descripcion, p.fecha_inicio, p.fecha_fin, p.responsable, p.cupo_maximo, tp.nombre_tipo, ep.nombre_estado FROM proyectos_barrio p JOIN tipos_proyecto tp ON p.id_tipo_proyecto = tp.id_tipo_proyecto JOIN estados_proyecto ep ON p.id_estado_proyecto = ep.id_estado_proyecto WHERE p.id_estado_proyecto = 1 ORDER BY p.id_proyecto;;
";

    $stmt = $pdo->prepare($sql);   // <-- si tu conexión se llama distinto, cámbiala aquí
    $stmt->execute();

    $proyecto = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!is_array($proyecto)) $proyecto = [];

} catch (Throwable $e) {
    $proyecto = [];
    // echo $e->getMessage(); // solo si estás debuggeando en local
}
