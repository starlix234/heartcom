<?php
require_once "conexion.php"; // PDO

if (!isset($_POST['id_certificado'], $_POST['accion'])) {
    exit("Solicitud inválida");
}

$id_certificado = (int) $_POST['id_certificado'];
$accion = $_POST['accion'];

if (!in_array($accion, ['aprobar', 'rechazar'])) {
    exit("Acción no permitida");
}

// Mapeo de acciones → id_estado
$mapaEstados = [
    'aprobar'  => 3,
    'rechazar' => 4
];

$id_estado = $mapaEstados[$accion];

$sql = "
    UPDATE solicitud_certificado
    SET id_estado = :id_estado
    WHERE id_certificado = :id_certificado
      AND id_estado = 1
";


$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_estado'      => $id_estado,
    ':id_certificado'=> $id_certificado
]);

if ($stmt->rowCount() === 0) {
    header("Location:../panel.php?resultado=sin_cambios");
    exit;
}

header("Location: ../panel.php?resultado=ok");
exit;
?>