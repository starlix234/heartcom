<?php   

session_start();
require_once 'conexion.php';

//datos a actualizar

$rut         = trim(strtoupper($_POST['rut']) ?? '');
$telefono    = trim($_POST['telefono'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$email       = trim($_POST['correo'] ?? '');


//actualizar datos en la base de datos
$sql = "UPDATE usuarios SET telefono = ?, direccion = ?, correo = ? WHERE rut = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$telefono, $direccion, $email, $rut]);
header("Location: ../admin-panel.php?msg=" . urlencode("Datos actualizados correctamente."));
exit;
?>