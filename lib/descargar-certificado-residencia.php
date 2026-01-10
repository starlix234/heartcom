<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die('Usuario no autenticado');
}

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php'; // AJUSTA si tu fpdf.php está en otra ruta

if (!isset($_GET['id_certificado'])) {
    die('Falta id_certificado');
}

$idCertificado = (int) $_GET['id_certificado'];

if ($idCertificado <= 0) {
    die('ID de certificado inválido');
}

/**
 * 1) Traer datos del certificado + usuario + estado de pago
 */
$sql = "
    SELECT 
        sc.id_certificado,
        sc.asunto,
        sc.mensaje,
        sc.created_at,
        tp.nombre_certificado,
        u.p_nombre,
        u.s_nombre,
        u.ap_paterno,
        u.ap_materno,
        u.rut,
        u.direccion,
        pr.id_estado AS id_estado_pago,
        pr.fecha_pago
    FROM solicitud_certificado sc
    JOIN tipos_certificados tp
        ON tp.id_certi = sc.id_certi
    JOIN usuarios u
        ON u.id_usuario = sc.id_usuario
    LEFT JOIN pagos_residencia pr
        ON pr.id_certificado = sc.id_certificado
    WHERE sc.id_certificado = :id_certificado
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->execute();
$cert = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cert) {
    die('Certificado no encontrado.');
}

/**
 * 2) Verificar que esté pagado
 *    En tu tabla `estados`: 1 = pagado, 2 = por pagar
 */
if ((int)$cert['id_estado_pago'] !== 1) {
    die('Este certificado aún no está pagado. No se puede descargar.');
}

/**
 * 3) Preparar datos
 */
$nombreCompleto = trim($cert['p_nombre'] . ' ' . $cert['s_nombre'] . ' ' . $cert['ap_paterno'] . ' ' . $cert['ap_materno']);
$fechaSolicitud = date('d-m-Y H:i', strtotime($cert['created_at']));
$fechaPago      = $cert['fecha_pago'] ? date('d-m-Y H:i', strtotime($cert['fecha_pago'])) : 'N/D';
$nombreCert     = $cert['nombre_certificado'];
$rut            = $cert['rut'];
$direccion      = $cert['direccion'];
$asunto         = $cert['asunto'];
$mensaje        = $cert['mensaje'];

/**
 * 4) Clase PDF personalizada
 */
class PDFCertificado extends FPDF
{
    function Header()
    {
        // Título principal
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, utf8_decode('Junta de Vecinos - Sistema Unidad Territorial'), 0, 1, 'C');
        $this->Ln(3);
    }

    function Footer()
    {
        // Número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDFCertificado();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

// Marco general
$pdf->SetLineWidth(0.5);
$pdf->Rect(10, 20, 190, 250);

// Título del certificado
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode($nombreCert), 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, utf8_decode('N° Certificado: ' . $cert['id_certificado']), 0, 1, 'C');
$pdf->Ln(8);

// Contenido
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Vecino(a):'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($nombreCompleto));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('RUT:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($rut));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Dirección:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($direccion));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Asunto de la solicitud:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($asunto));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Descripción / Motivo:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($mensaje));
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Fecha de solicitud:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($fechaSolicitud));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Fecha de pago:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($fechaPago));
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Estado de pago:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode('PAGADO'));
$pdf->Ln(20);

/**
 * 5) Sello/timbre (opcional)
 *    Si creas una imagen de sello (por ejemplo sello_junta.png)
 *    y la guardas en: heartcom/lib/img/sello_junta.png
 *    este bloque la insertará en el certificado.
 */
$selloPath = __DIR__ . '/img/sello_junta.png';
if (file_exists($selloPath)) {
    // x, y, ancho. Alto se ajusta proporcionalmente
    $pdf->Image($selloPath, 140, 200, 40);
}

// Texto de “firma” genérico, por si no hay sello real
$pdf->SetY(230);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, utf8_decode('_______________________________'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Directiva Junta de Vecinos'), 0, 1, 'C');

// 6) Enviar PDF al navegador
$filename = 'certificado_' . $idCertificado . '.pdf';
$pdf->Output('I', $filename); // 'I' = inline en el navegador
exit;
