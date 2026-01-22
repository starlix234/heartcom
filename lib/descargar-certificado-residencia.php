<?php
/*******************************
 * BLINDAJE TOTAL PARA FPDF
 *******************************/
ini_set('display_errors', '0'); // 🔇 nunca mostrar errores
ini_set('log_errors', '1');
error_reporting(E_ALL);

ob_start(); // 🔒 buffer FORZADO
session_start();

/*******************************
 * VALIDACIONES
 *******************************/
if (!isset($_SESSION['id_usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

if (!isset($_GET['id_certificado'])) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

$idCertificado = (int) $_GET['id_certificado'];
$idUsuario     = (int) $_SESSION['id_usuario'];

if ($idCertificado <= 0) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

/*******************************
 * INCLUDES (SIN SALIDA)
 *******************************/
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

/*******************************
 * CONSULTA
 *******************************/
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
    JOIN tipos_certificados tp ON tp.id_certi = sc.id_certi
    JOIN usuarios u ON u.id_usuario = sc.id_usuario
    LEFT JOIN pagos_residencia pr
        ON pr.id_certificado = sc.id_certificado
       AND pr.id_pago = (
            SELECT MAX(id_pago)
            FROM pagos_residencia
            WHERE id_certificado = sc.id_certificado
       )
    WHERE sc.id_certificado = :id_certificado
      AND sc.id_usuario = :id_usuario
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_certificado' => $idCertificado,
    ':id_usuario'     => $idUsuario
]);

$cert = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cert) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

if ((int)$cert['id_estado_pago'] !== 1) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

/*******************************
 * DATOS
 *******************************/
$nombreCompleto = trim(
    $cert['p_nombre'].' '.
    $cert['s_nombre'].' '.
    $cert['ap_paterno'].' '.
    $cert['ap_materno']
);

$fechaSolicitud = date('d-m-Y H:i', strtotime($cert['created_at']));
$fechaPago      = $cert['fecha_pago']
    ? date('d-m-Y H:i', strtotime($cert['fecha_pago']))
    : 'N/D';

/*******************************
 * PDF
 *******************************/
class PDFCertificado extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,utf8_decode('Junta de Vecinos - Sistema Unidad Territorial'),0,1,'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
    }
}

$pdf = new PDFCertificado();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,utf8_decode($cert['nombre_certificado']),0,1,'C');

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,7,utf8_decode('N° Certificado: '.$cert['id_certificado']),0,1,'C');
$pdf->Ln(10);

function campo($pdf, $titulo, $texto) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,utf8_decode($titulo),0,1);
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0,6,utf8_decode($texto));
    $pdf->Ln(2);
}

campo($pdf,'Vecino(a):',$nombreCompleto);
campo($pdf,'RUT:',$cert['rut']);
campo($pdf,'Dirección:',$cert['direccion']);
campo($pdf,'Asunto:',$cert['asunto']);
campo($pdf,'Descripción:',$cert['mensaje']);
campo($pdf,'Fecha solicitud:',$fechaSolicitud);
campo($pdf,'Fecha pago:',$fechaPago);

/*******************************
 * SALIDA FINAL LIMPIA
 *******************************/
while (ob_get_level()) {
    ob_end_clean(); // 🧹 LIMPIEZA TOTAL
}

$pdf->Output('I', 'certificado_'.$idCertificado.'.pdf');
exit;
