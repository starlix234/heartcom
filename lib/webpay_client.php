<?php
require_once __DIR__ . '/webpayconfig.php';
function webpay_request($method, $endpoint, $body = null) {
    $url = WEBPAY_BASE_URL . $endpoint;

    $ch = curl_init($url);

    $headers = [
        'Tbk-Api-Key-Id: ' . WEBPAY_API_KEY_ID,
        'Tbk-Api-Key-Secret: ' . WEBPAY_API_KEY_SECRET,
        'Content-Type: application/json',
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            if ($body !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            }
            break;
        case 'PUT':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($body !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            }
            break;
        case 'GET':
            // nada extra
            break;
        default:
            throw new Exception('Método HTTP no soportado');
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception('Error cURL: ' . $error);
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($httpCode < 200 || $httpCode >= 300) {
        // Puedes logear $response completo
        throw new Exception('Error Webpay HTTP ' . $httpCode . ': ' . $response);
    }

    return $data;
}
