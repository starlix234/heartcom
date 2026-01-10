<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die('Usuario no autenticado');
}

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php'; // Asegúrate que exista: lib/fpdf/fpdf.php

if (!isset($_GET['id_certificado'])) {
    die('Falta id_certificado');
}

$idCertificado = (int) $_GET['id_certificado'];

if ($idCertificado <= 0) {
    die('ID de certificado inválido');
}

/**
 * 1) Traer datos básicos del certificado, usuario y estado
 *    Aquí consideramos TODOS los tipos, pero este script lo usarás
 *    solo para los que NO son de residencia (id_certi != 1)
 */
$sql = "
    SELECT 
        sc.id_certificado,
        sc.id_estado,
        sc.asunto,
        sc.mensaje,
        sc.created_at,
        tp.id_certi,
        tp.nombre_certificado,
        u.p_nombre,
        u.s_nombre,
        u.ap_paterno,
        u.ap_materno,
        u.rut,
        u.direccion,
        est.nombre_estado AS estado_solicitud
    FROM solicitud_certificado sc
    JOIN tipos_certificados tp
        ON tp.id_certi = sc.id_certi
    JOIN usuarios u
        ON u.id_usuario = sc.id_usuario
    JOIN estados_certificado est
        ON est.id_estados_certificado = sc.id_estado
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

// Este script es para los “normales”: NO residencia
if ((int)$cert['id_certi'] === 1) {
    die('Este script no es para certificados de residencia.');
}

/**
 * 2) Validar que esté aprobado
 */
$idEstado        = (int)$cert['id_estado'];
$estadoSolicitud = strtolower($cert['estado_solicitud'] ?? '');
$esAprobada      = ($idEstado === 3 || $estadoSolicitud === 'aprobado');

if (!$esAprobada) {
    die('Este certificado aún no está aprobado. No se puede descargar.');
}

/**
 * 3) Preparar datos
 */
$nombreCompleto = trim($cert['p_nombre'] . ' ' . $cert['s_nombre'] . ' ' . $cert['ap_paterno'] . ' ' . $cert['ap_materno']);
$fechaSolicitud = date('d-m-Y', strtotime($cert['created_at']));
$nombreCert     = $cert['nombre_certificado'];
$rut            = $cert['rut'];
$direccion      = $cert['direccion'];
$asunto         = $cert['asunto'];
$mensaje        = $cert['mensaje'];

/**
 * 4) PDF simple
 */
class PDFCertSimple extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, utf8_decode('Junta de Vecinos - Sistema Unidad Territorial'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDFCertSimple();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

// Título del certificado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode($nombreCert), 0, 1, 'C');
$pdf->Ln(5);

// Datos básicos
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(40, 7, utf8_decode('N° Certificado:'), 0, 0);
$pdf->Cell(0, 7, utf8_decode($cert['id_certificado']), 0, 1);

$pdf->Cell(40, 7, utf8_decode('Fecha emisión:'), 0, 0);
$pdf->Cell(0, 7, utf8_decode($fechaSolicitud), 0, 1);
$pdf->Ln(5);

$pdf->Cell(40, 7, utf8_decode('Vecino(a):'), 0, 0);
$pdf->Cell(0, 7, utf8_decode($nombreCompleto), 0, 1);

$pdf->Cell(40, 7, utf8_decode('RUT:'), 0, 0);
$pdf->Cell(0, 7, utf8_decode($rut), 0, 1);

$pdf->Cell(40, 7, utf8_decode('Dirección:'), 0, 0);
$pdf->Cell(0, 7, utf8_decode($direccion), 0, 1);
$pdf->Ln(8);

// Asunto y motivo
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Asunto:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($asunto));
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, utf8_decode('Motivo / Detalle:'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 6, utf8_decode($mensaje));
$pdf->Ln(20);

// “Firma” simple
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, utf8_decode('_______________________________'), 0, 1, 'C');
$pdf->Cell(0, 7, utf8_decode('Directiva Junta de Vecinos'), 0, 1, 'C');

// Si algún día pones un sello.png en lib/img/sello_junta.png
$selloPath = __DIR__ . '/img/sello_junta.png';
if (file_exists($selloPath)) {
    $pdf->Image($selloPath, 140, 200, 40);
}

// Salida
$filename = 'certificado_simple_' . $idCertificado . '.pdf';
$pdf->Output('I', $filename);
exit;
