<?php
require_once("conexion.php");

if (!isset($_POST['id_proyecto'])) {
    header("Location: administrar-proyectos.php");
    exit;
}

$id = $_POST['id_proyecto'];

// Cambiar estado (ejemplo: 1 = Activo, 2 = Inactivo)
$sql = "
UPDATE proyectos_barrio
SET id_estado_proyecto = 
    CASE 
        WHEN id_estado_proyecto = 1 THEN 2
        ELSE 1
    END
WHERE id_proyecto = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: administrar-proyectos.php");
exit;
