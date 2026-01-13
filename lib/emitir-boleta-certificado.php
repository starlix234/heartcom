<?php
session_start();

// 1. Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    exit('No autorizado');
}

$idUsuario = (int) $_SESSION['id_usuario'];

// 2. Validar parámetro
if (!isset($_GET['id_certificado'])) {
    exit('Falta parámetro id_certificado');
}

$idCertificado = (int) $_GET['id_certificado'];

// 3. Conexión a BD
require_once 'conexion.php'; // Debe crear $pdo (PDO)

// 4. Buscar datos del certificado + usuario + pago + transacción WebPay
//   - Solo certificados de residencia (id_certi = 1)
//   - Solo pagos con estado "pagado" (estados.estado = 'pagado')
//   - Usa la última transacción AUTORIZADA de WebPay si hay más de una

$sql = "
    SELECT 
        s.id_certificado,
        s.id_certi,
        s.asunto,
        s.mensaje,
        s.created_at                         AS fecha_solicitud,

        -- Usuario
        CONCAT(u.p_nombre, ' ', u.s_nombre, ' ', u.ap_paterno, ' ', u.ap_materno) AS nombre_completo,
        u.rut,
        u.direccion,
        u.correo,
        u.telefono,

        -- Tipo certificado
        t.nombre_certificado,

        -- Pago registrado
        pr.monto                             AS monto_pagado,
        pr.fecha_pago,

        -- Estado de pago (tabla estados)
        e.estado                             AS estado_pago,

        -- Transacción WebPay (puede ser NULL si algo falló)
        tw.orden_compra,
        tw.codigo_autorizacion,
        tw.medio_pago,
        tw.numero_cuotas,
        tw.tipo_cuotas,
        tw.estado_transaccion,
        tw.fecha_transaccion,
        tw.last4_tarjeta
    FROM solicitud_certificado s
    JOIN usuarios u 
        ON u.id_usuario = s.id_usuario
    JOIN tipos_certificados t
        ON t.id_certi = s.id_certi
    JOIN pagos_residencia pr
        ON pr.id_certificado = s.id_certificado
    JOIN estados e
        ON e.id_estado = pr.id_estado
    LEFT JOIN transacciones_webpay tw
        ON tw.id_certificado = s.id_certificado
        AND tw.estado_transaccion = 'AUTORIZADA'
    WHERE 
        s.id_certificado = :id_certificado
        AND s.id_usuario   = :id_usuario
        AND s.id_certi     = 1              -- solo certificados de residencia
        AND e.estado       = 'pagado'       -- solo si está pagado
    ORDER BY 
        tw.id_transaccion DESC
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario',    $idUsuario,    PDO::PARAM_INT);
$stmt->execute();

$boleta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$boleta) {
    exit('No se encontró una boleta válida para este certificado (no pagado o no pertenece al usuario).');
}

// 5. Cargar librería FPDF (ajusta la ruta según tu proyecto)
require_once __DIR__ . '/../fpdf/fpdf.php';

// 6. Crear PDF de la boleta
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Encabezado
$pdf->Cell(0, 10, utf8_decode('Boleta de Pago - Junta de Vecinos'), 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode('Sistema Unidad Territorial (HeartCom)'), 0, 1, 'L');
$pdf->Cell(0, 6, utf8_decode('Comprobante de pago de certificado de residencia'), 0, 1, 'L');
$pdf->Ln(4);

// Línea separadora
$pdf->Cell(0, 0, '', 'T', 1);
$pdf->Ln(4);

// Datos del vecino
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Datos del vecino'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Nombre: ') . utf8_decode($boleta['nombre_completo']), 0, 1);
$pdf->Cell(0, 5, 'RUT: ' . $boleta['rut'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Dirección: ') . utf8_decode($boleta['direccion']), 0, 1);
$pdf->Cell(0, 5, 'Correo: ' . $boleta['correo'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Teléfono: ') . $boleta['telefono'], 0, 1);
$pdf->Ln(4);

// Datos del certificado
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Detalle del certificado'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'ID Certificado: ' . $boleta['id_certificado'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Tipo: ') . utf8_decode($boleta['nombre_certificado']), 0, 1);
$pdf->MultiCell(0, 5, utf8_decode('Asunto: ') . utf8_decode($boleta['asunto']), 0, 'L');
$pdf->Cell(0, 5, utf8_decode('Fecha solicitud: ') . $boleta['fecha_solicitud'], 0, 1);
$pdf->Ln(4);

// Datos del pago
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Datos del pago'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Estado pago: ') . utf8_decode($boleta['estado_pago']), 0, 1);
$pdf->Cell(0, 5, utf8_decode('Fecha pago (registro interno): ') . $boleta['fecha_pago'], 0, 1);

$montoFormateado = number_format((int)$boleta['monto_pagado'], 0, ',', '.');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Monto pagado: $' . $montoFormateado, 0, 1);

// Datos WebPay (si existen)
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Detalle transaccion WebPay', 0, 1);

$pdf->SetFont('Arial', '', 10);
if (!empty($boleta['orden_compra'])) {
    $pdf->Cell(0, 5, 'Orden de compra: ' . $boleta['orden_compra'], 0, 1);
    $pdf->Cell(0, 5, 'Codigo autorizacion: ' . $boleta['codigo_autorizacion'], 0, 1);
    $pdf->Cell(0, 5, utf8_decode('Medio de pago: ') . $boleta['medio_pago'], 0, 1);
    $pdf->Cell(0, 5, utf8_decode('Últimos 4 dígitos tarjeta: ') . $boleta['last4_tarjeta'], 0, 1);
    $pdf->Cell(0, 5, 'Estado transaccion: ' . $boleta['estado_transaccion'], 0, 1);
    $pdf->Cell(0, 5, 'Fecha transaccion: ' . $boleta['fecha_transaccion'], 0, 1);

    if (!empty($boleta['numero_cuotas'])) {
        $pdf->Cell(0, 5, 'Cuotas: ' . $boleta['numero_cuotas'] . ' (' . $boleta['tipo_cuotas'] . ')', 0, 1);
    }
} else {
    $pdf->Cell(0, 5, utf8_decode('Sin datos de transacción WebPay asociados (pago registrado manualmente).'), 0, 1);
}

// Nota final
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, utf8_decode(
    'Esta boleta acredita el pago registrado para el certificado de residencia indicado. '
    . 'Conserve este documento como comprobante. '
    . 'Cualquier duda o corrección debe gestionarse con la directiva de la junta de vecinos.'
));

// 7. Salida del PDF
$nombreArchivo = 'boleta_certificado_' . $boleta['id_certificado'] . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $nombreArchivo . '"');

$pdf->Output('I', $nombreArchivo);
exit;
