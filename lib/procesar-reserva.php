<?php
session_start();
require_once 'conexion.php';

// (Opcional) Validar que sea admin/jefe
// if (!isset($_SESSION['id_rol']) || !in_array($_SESSION['id_rol'], [1,2])) {
//     die('Acceso no autorizado');
// }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listado-reservas.php?msg=" . urlencode("Petición inválida."));
    exit;
}

$idReserva = isset($_POST['id_reserva']) ? (int)$_POST['id_reserva'] : 0;
$accion    = $_POST['accion'] ?? '';

if ($idReserva <= 0 || !in_array($accion, ['aprobar', 'rechazar'], true)) {
    header("Location: listado-reservas.php?msg=" . urlencode("Datos inválidos para procesar la reserva."));
    exit;
}

/**
 * Mapa de estados por ID según tu tabla estado_reserva:
 * 1 = en proceso
 * 2 = aprobado
 * 3 = rechazado
 */
$estadoMap = [
    'aprobar'  => ['id' => 2, 'texto' => 'aprobado',  'correo_texto' => 'aprobada'],
    'rechazar' => ['id' => 3, 'texto' => 'rechazado', 'correo_texto' => 'rechazada'],
];

$idEstado      = $estadoMap[$accion]['id'];
$estadoTexto   = $estadoMap[$accion]['texto'];        // para info interna
$mensajeAccion = $estadoMap[$accion]['correo_texto']; // para redacción correo

try {

    // 1️⃣ Actualizar el estado de la reserva
    $sqlUpdate = "
        UPDATE reservas 
        SET id_estado_reserva = :id_estado 
        WHERE id_reserva = :id_reserva
    ";
    $stmt = $pdo->prepare($sqlUpdate);
    $stmt->execute([
        ':id_estado'  => $idEstado,
        ':id_reserva' => $idReserva
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("No se pudo actualizar la reserva (verifica el ID).");
    }

    // 2️⃣ Obtener datos de la reserva + vecino para el correo
    $sqlDatos = "
        SELECT 
            r.id_reserva,
            r.Fecha_ini,
            r.Fecha_fin,
            r.asunto,
            r.motivo,
            t.tipo,
            er.estado AS estado_reserva,
            CONCAT_WS(' ', u.p_nombre, u.s_nombre, u.ap_paterno, u.ap_materno) AS nombre_completo,
            u.correo
        FROM reservas r
        JOIN tipo_reserva t   ON r.id_tipo = t.id_tipo
        JOIN estado_reserva er ON r.id_estado_reserva = er.id_estado_reserva
        JOIN usuarios u       ON r.id_usuario = u.id_usuario
        WHERE r.id_reserva = :id_reserva
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sqlDatos);
    $stmt->execute([':id_reserva' => $idReserva]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        throw new Exception("No se encontraron datos de la reserva luego de la actualización.");
    }

    $correoVecino   = $reserva['correo'];
    $nombreVecino   = $reserva['nombre_completo'];
    $tipoReserva    = $reserva['tipo'];
    $fechaIni       = $reserva['Fecha_ini'];
    $fechaFin       = $reserva['Fecha_fin'];
    $asuntoReserva  = $reserva['asunto'];
    $motivoReserva  = $reserva['motivo'];
    $estadoFinal    = $reserva['estado_reserva'];

    // 3️⃣ Enviar correo al vecino

    $asuntoCorreo = "Actualización de tu reserva en la Junta de Vecinos";

    $mensajeCorreo  = "Estimado/a $nombreVecino:\r\n\r\n";
    $mensajeCorreo .= "Tu solicitud de reserva ha sido $mensajeAccion.\r\n\r\n";
    $mensajeCorreo .= "Detalles de la reserva:\r\n";
    $mensajeCorreo .= "- Tipo de reserva: $tipoReserva\r\n";
    $mensajeCorreo .= "- Asunto: $asuntoReserva\r\n";
    $mensajeCorreo .= "- Motivo: $motivoReserva\r\n";
    $mensajeCorreo .= "- Fecha inicio: $fechaIni\r\n";
    $mensajeCorreo .= "- Fecha fin: $fechaFin\r\n";
    $mensajeCorreo .= "- Estado final en el sistema: $estadoFinal\r\n\r\n";
    $mensajeCorreo .= "Ante cualquier duda, comunícate con la directiva de la junta de vecinos.\r\n\r\n";
    $mensajeCorreo .= "Atentamente,\r\n";
    $mensajeCorreo .= "Sistema de Reservas - Junta de Vecinos\r\n";

    // Cabeceras
    $headers  = "From: \"Junta de Vecinos\" <no-responder@tusitio.cl>\r\n";
    $headers .= "Reply-To: no-responder@tusitio.cl\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Enviar correo (no rompe si falla, solo sigue)
    @mail($correoVecino, $asuntoCorreo, $mensajeCorreo, $headers);

    // 4️⃣ Volver al listado con mensaje
    header("Location: ../modulo-reservas/reservas.php?msg=" . urlencode("Reserva $mensajeAccion y correo de notificación enviado (si el servidor de correo está bien configurado)."));
    exit;

} catch (Exception $e) {
    header("Location: ../modulo-reservas/reservas.php?msg=" . urlencode("Error al procesar la reserva: " . $e->getMessage()));
    exit;
}
