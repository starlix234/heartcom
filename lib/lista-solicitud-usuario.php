<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die('Usuario no autenticado');
}

$idUsuario = (int) $_SESSION['id_usuario'];

require_once 'conexion.php'; // crea $pdo

$sql = "
    SELECT 
        s.id_certificado,
        s.asunto,
        s.mensaje,
        s.created_at,
        
        t.id_certi,
        t.nombre_certificado,
        
        e.nombre_estado              AS estado_solicitud,
        
        pr.monto,
        es.estado                    AS estado_pago,
        
        CASE 
            WHEN t.id_certi = 1                 -- solo certificados de residencia
             AND pr.id_pago IS NOT NULL         -- tiene registro de pago
             AND es.estado = 'por pagar'        -- y está por pagar
            THEN 1
            ELSE 0
        END AS puede_pagar
        
    FROM solicitud_certificado s
    JOIN tipos_certificados t 
        ON t.id_certi = s.id_certi 
    JOIN estados_certificado e 
        ON e.id_estados_certificado = s.id_estado
    LEFT JOIN pagos_residencia pr
        ON pr.id_certificado = s.id_certificado
    LEFT JOIN estados es
        ON es.id_estado = pr.id_estado
    WHERE s.id_usuario = :id_usuario
    ORDER BY s.created_at DESC
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);