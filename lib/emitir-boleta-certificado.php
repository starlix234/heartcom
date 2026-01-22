<?php
ob_start(); // 🔒 BLINDA FPDF
session_start();

/* ===============================
   1. Validaciones SIN salida
================================ */

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    exit;
}

if (!isset($_GET['id_certificado'])) {
    http_response_code(400);
    exit;
}

$idUsuario      = (int) $_SESSION['id_usuario'];
$idCertificado  = (int) $_GET['id_certificado'];

if ($idCertificado <= 0) {
    http_response_code(400);
    exit;
}

/* ===============================
   2. Conexión BD
================================ */

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

/* ===============================
   3. Consulta boleta
================================ */

$sql = "
    SELECT
        s.id_certificado,
        s.asunto,
        s.mensaje,
        s.created_at AS fecha_solicitud,

        CONCAT(u.p_nombre,' ',u.s_nombre,' ',u.ap_paterno,' ',u.ap_materno) AS nombre_completo,
        u.rut,
        u.direccion,
        u.correo,
        u.telefono,

        t.nombre_certificado,

        pr.monto AS monto_pagado,
        pr.fecha_pago,

        e.estado AS estado_pago,

        tw.orden_compra,
        tw.codigo_autorizacion,
        tw.medio_pago,
        tw.numero_cuotas,
        tw.tipo_cuotas,
        tw.estado_transaccion,
        tw.fecha_transaccion,
        tw.last4_tarjeta
    FROM solicitud_certificado s
    JOIN usuarios u ON u.id_usuario = s.id_usuario
    JOIN tipos_certificados t ON t.id_certi = s.id_certi
    JOIN pagos_residencia pr ON pr.id_certificado = s.id_certificado
    JOIN estados e ON e.id_estado = pr.id_estado
    LEFT JOIN transacciones_webpay tw
        ON tw.id_certificado = s.id_certificado
        AND tw.estado_transaccion = 'AUTORIZADA'
    WHERE
        s.id_certificado = :id_certificado
        AND s.id_usuario = :id_usuario
        AND s.id_certi   = 1
        AND e.estado     = 'pagado'
    ORDER BY tw.id_transaccion DESC
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

$boleta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$boleta) {
    http_response_code(404);
    exit;
}

/* ===============================
   4. Crear PDF
================================ */

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

/* Encabezado */
$pdf->Cell(0, 10, utf8_decode('Boleta de Pago - Junta de Vecinos'), 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode('Sistema Unidad Territorial (HeartCom)'), 0, 1);
$pdf->Cell(0, 6, utf8_decode('Comprobante de pago de certificado de residencia'), 0, 1);
$pdf->Ln(4);

$pdf->Cell(0, 0, '', 'T', 1);
$pdf->Ln(4);

/* Datos vecino */
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Datos del vecino'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Nombre: ') . utf8_decode($boleta['nombre_completo']), 0, 1);
$pdf->Cell(0, 5, 'RUT: ' . $boleta['rut'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Dirección: ') . utf8_decode($boleta['direccion']), 0, 1);
$pdf->Cell(0, 5, 'Correo: ' . $boleta['correo'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Teléfono: ') . $boleta['telefono'], 0, 1);
$pdf->Ln(4);

/* Certificado */
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Detalle del certificado'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'ID Certificado: ' . $boleta['id_certificado'], 0, 1);
$pdf->Cell(0, 5, utf8_decode('Tipo: ') . utf8_decode($boleta['nombre_certificado']), 0, 1);
$pdf->MultiCell(0, 5, utf8_decode('Asunto: ') . utf8_decode($boleta['asunto']));
$pdf->Cell(0, 5, 'Fecha solicitud: ' . $boleta['fecha_solicitud'], 0, 1);
$pdf->Ln(4);

/* Pago */
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, utf8_decode('Datos del pago'), 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, utf8_decode('Estado: ') . utf8_decode($boleta['estado_pago']), 0, 1);
$pdf->Cell(0, 5, utf8_decode('Fecha pago: ') . $boleta['fecha_pago'], 0, 1);

$monto = number_format((int)$boleta['monto_pagado'], 0, ',', '.');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Monto pagado: $' . $monto, 0, 1);

/* WebPay */
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 6, 'Detalle transaccion WebPay', 0, 1);

$pdf->SetFont('Arial', '', 10);
if (!empty($boleta['orden_compra'])) {
    $pdf->Cell(0, 5, 'Orden compra: ' . $boleta['orden_compra'], 0, 1);
    $pdf->Cell(0, 5, 'Codigo autorizacion: ' . $boleta['codigo_autorizacion'], 0, 1);
    $pdf->Cell(0, 5, 'Medio pago: ' . $boleta['medio_pago'], 0, 1);
    $pdf->Cell(0, 5, 'Ultimos 4 digitos: ' . $boleta['last4_tarjeta'], 0, 1);
    $pdf->Cell(0, 5, 'Estado: ' . $boleta['estado_transaccion'], 0, 1);
    $pdf->Cell(0, 5, 'Fecha: ' . $boleta['fecha_transaccion'], 0, 1);
}

/* ===============================
   5. SALIDA LIMPIA
================================ */

if (ob_get_length()) {
    ob_end_clean();
}

$pdf->Output('I', 'boleta_certificado_' . $boleta['id_certificado'] . '.pdf');
exit;
