<?php
require("conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $id_certi = $_POST['id_certi'] ?? null; // Cambia según la clave del formulario
    $id_usuario = $_POST['id_usuario'] ?? null; // Cambia según la clave del formulario
    $asunto = $_POST['asunto'] ?? null; // Cambia según la clave del formulario
    $mensaje = $_POST['mensaje'] ?? ''; // Cambia según la clave del formulario

    try {
        // Consulta de inserción
        $sql = "INSERT INTO solicitud_certificado (id_certificado, id_certi, id_usuario, asunto, mensaje)
                VALUES (NULL, ?, ?, ?, ?)"; // Dejar id_certificado como NULL

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_certi, $id_usuario, $asunto, $mensaje]);

        echo "Nuevo registro creado correctamente";
    } catch (PDOException $e) {
        echo "Error al insertar el registro: " . $e->getMessage();
    }
} else {
    echo "No se recibieron datos por POST.";
}
?>