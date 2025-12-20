<?php
require_once "conexion.php";
session_start();

/* Validar rol */

$sql = "
SELECT sc.id_certificado, tp.nombre_certificado, sc.asunto, sc.mensaje, sc.created_at, CONCAT_WS(' ', u.p_nombre, u.s_nombre) AS nombre, CONCAT_WS(' ',u.ap_paterno,u.ap_materno) as apellido, u.rut FROM solicitud_certificado sc JOIN usuarios u ON sc.id_usuario = u.id_usuario JOIN tipos_certificados tp on tp.id_certi=sc.id_certi WHERE sc.id_estado = 1 ORDER BY sc.created_at DESC;
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
