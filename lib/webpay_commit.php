<?php
session_start();

/**
 * 1) Includes con rutas correctas
 *    __DIR__ = C:\xampp\htdocs\heartcom\lib
 */
require_once __DIR__ . '/conexion.php';      // sube a la raíz
require_once __DIR__ . '/webpay_client.php';    // mismo directorio /lib

/**
 * 2) Recuperar token desde POST o GET.
 *    Cuando el usuario aborta, Transbank puede mandar TBK_TOKEN.
 */
$token = $_POST['token_ws'] ?? $_GET['token_ws'] ?? null;

if (!$token) {
    // Caso aborto/cancelación explícita desde Webpay
    if (isset($_POST['TBK_TOKEN']) || isset($_GET['TBK_TOKEN'])) {
        header('Location: resultado_pago.php?success=0&motivo=abortado');
        exit;
    }

    // Caso genérico: no llegó nada
    die('No se recibió token_ws, el pago fue abortado o falló.');
}

/**
 * 3) Confirmar transacción con Webpay (REST)
 *    Endpoint: /transactions/{token}
 */
$endpoint = WEBPAY_TX_ENDPOINT . '/' . $token;

try {
    $response = webpay_request('PUT', $endpoint);
} catch (Exception $e) {
    die('Error al confirmar transacción Webpay: ' . $e->getMessage());
}

/*
 Ejemplo de respuesta (simplificada):
 {
   "vci": "TSY",
   "amount": 1000,
   "status": "AUTHORIZED",
   "buy_order": "ordenCompra123",
   "session_id": "sesion1234",
   "card_detail": {
     "card_number": "6623"
   },
   "accounting_date": "0328",
   "transaction_date": "2019-03-28T17:09:45.258Z",
   "authorization_code": "1213",
   "payment_type_code": "VN",
   "response_code": 0,
   "installments_amount": 0,
   "installments_number": 0,
   "balance": 0
 }
*/

// 4) Extraer datos relevantes de la respuesta
$buyOrder        = $response['buy_order']          ?? null;
$amount          = $response['amount']             ?? null;
$status          = $response['status']             ?? null;
$responseCode    = $response['response_code']      ?? null;
$authCode        = $response['authorization_code'] ?? null;
$paymentTypeCode = $response['payment_type_code']  ?? null;
$installments    = $response['installments_number'] ?? 0;
$cardNumber      = $response['card_detail']['card_number'] ?? null;

/**
 * 5) Buscar la transacción en tu BD por token_ws
 */
$stmt = $pdo->prepare("
    SELECT * 
    FROM transacciones_webpay
    WHERE token_ws = :token_ws
    LIMIT 1
");
$stmt->bindValue(':token_ws', $token, PDO::PARAM_STR);
$stmt->execute();
$tx = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tx) {
    die('Transacción no encontrada en el sistema.');
}

$idTransaccion = (int) $tx['id_transaccion'];
$idCertificado = (int) $tx['id_certificado'];

/**
 * 6) Evaluar si la transacción fue exitosa
 *    Éxito = response_code = 0 y status = AUTHORIZED
 */
$exito = ($responseCode === 0 && $status === 'AUTHORIZED');

/**
 * 7) Actualizar transacción en tu BD
 */
$stmt = $pdo->prepare("
    UPDATE transacciones_webpay
    SET estado_transaccion = :estado,
        monto = :monto,
        codigo_autorizacion = :codigo_autorizacion,
        medio_pago = :medio_pago,
        numero_cuotas = :numero_cuotas,
        tipo_cuotas = :tipo_cuotas,
        last4_tarjeta = :last4,
        respuesta_json = :respuesta_json
    WHERE id_transaccion = :id_transaccion
");

$estado = $exito ? 'AUTORIZADA' : 'RECHAZADA';

$stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
$stmt->bindValue(':monto', $amount, PDO::PARAM_INT);
$stmt->bindValue(':codigo_autorizacion', $authCode, PDO::PARAM_STR);
$stmt->bindValue(':medio_pago', $paymentTypeCode, PDO::PARAM_STR);
$stmt->bindValue(':numero_cuotas', $installments, PDO::PARAM_INT);
$stmt->bindValue(':tipo_cuotas', null, PDO::PARAM_NULL);
$stmt->bindValue(':last4', $cardNumber ? substr($cardNumber, -4) : null, PDO::PARAM_STR);
$stmt->bindValue(':respuesta_json', json_encode($response), PDO::PARAM_STR);
$stmt->bindValue(':id_transaccion', $idTransaccion, PDO::PARAM_INT);
$stmt->execute();

/**
 * 8) Actualizar estado de pago en pagos_residencia
 *    id_estado = 1 → pagado (según tu tabla `estados`)
 */
if ($exito) {
    $stmt = $pdo->prepare("
        UPDATE pagos_residencia
        SET id_estado = 1, fecha_pago = NOW()
        WHERE id_certificado = :id_certificado
    ");
    $stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
    $stmt->execute();

    // Redirigir a página de éxito, donde mostrarás "Descargar certificado"
    header('Location: resultado_pago.php?success=1&id_certificado=' . $idCertificado);
    exit;
} else {
    // Redirigir a página de fallo
    header('Location: resultado_pago.php?success=0&id_certificado=' . $idCertificado);
    exit;
}
