<?php
session_start();

/**
 * 1) Validar sesión
 */
if (!isset($_SESSION['id_usuario'])) {
    die('Usuario no autenticado');
}

/**
 * 2) Includes con rutas correctas
 *    __DIR__ = C:\xampp\htdocs\heartcom\lib
 */
require_once __DIR__ . '/conexion.php';      // sube a la raíz
require_once __DIR__ . '/webpay_client.php';    // mismo directorio /lib
require_once __DIR__ . '/helpers.php';          // mismo directorio /lib

$idUsuario = (int) $_SESSION['id_usuario'];

/**
 * 3) Obtener id_certificado desde POST (form) o GET (link)
 */
$idCertificado = 0;

if (isset($_POST['id_certificado'])) {
    $idCertificado = (int) $_POST['id_certificado'];
} elseif (isset($_GET['id_certificado'])) {
    $idCertificado = (int) $_GET['id_certificado'];
}

if ($idCertificado <= 0) {
    die('Falta id_certificado');
}

/**
 * 4) Obtener / definir monto desde pagos_residencia
 */
$sql = "SELECT id_pago, monto 
        FROM pagos_residencia
        WHERE id_certificado = :id_certificado
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->execute();
$pago = $stmt->fetch(PDO::FETCH_ASSOC);

if ($pago) {
    $monto = (int) $pago['monto'];
} else {
    // TODO: aquí puedes poner tu lógica real de monto dinámico
    $monto = 2000; // valor por defecto de ejemplo

    $stmtIns = $pdo->prepare("
        INSERT INTO pagos_residencia (id_certificado, id_estado, monto, fecha_pago)
        VALUES (:id_certificado, 2, :monto, NULL)
    ");
    $stmtIns->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
    $stmtIns->bindValue(':monto', $monto, PDO::PARAM_INT);
    $stmtIns->execute();
}

/**
 * 5) Validar que la solicitud exista y esté APROBADA (id_estado = 3)
 */
$sql = "SELECT sc.id_certificado, sc.id_estado, tp.nombre_certificado
        FROM solicitud_certificado sc
        JOIN tipos_certificados tp ON tp.id_certi = sc.id_certi
        WHERE sc.id_certificado = :id_certificado
          AND sc.id_usuario = :id_usuario
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$sol = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sol) {
    die('Solicitud no encontrada para este usuario');
}

if ((int) $sol['id_estado'] !== 3) {
    die('La solicitud aún no está aprobada para pago.');
}

/**
 * 6) Preparar datos para Webpay (REST)
 */
$buyOrder  = 'CERT-' . $idCertificado . '-' . time();
$sessionId = 'USR-' . $idUsuario . '-' . session_id();

/**
 * URL de retorno dinámica (sirve en local y en la nube)
 * getBaseUrl() viene de helpers.php
 * Ej:
 *   http://localhost/heartcom/lib/iniciar-pago.php
 * → http://localhost/heartcom/lib
 */
$baseUrl   = getBaseUrl();
$returnUrl = $baseUrl . '/webpay_commit.php';

$body = [
    'buy_order'  => $buyOrder,
    'session_id' => $sessionId,
    'amount'     => $monto,
    'return_url' => $returnUrl,
];

/**
 * 7) Llamar a Webpay (crear transacción)
 */
try {
    $response = webpay_request('POST', WEBPAY_TX_ENDPOINT, $body);
} catch (Exception $e) {
    die('Error al crear transacción Webpay: ' . $e->getMessage());
}

// Respuesta Webpay REST
$token = $response['token'] ?? null;
$url   = $response['url']   ?? null;

if (!$token || !$url) {
    die('Respuesta de Webpay inválida');
}

/**
 * 8) Registrar transacción en tu BD
 */
$stmt = $pdo->prepare("
    INSERT INTO transacciones_webpay
        (id_certificado, id_usuario, monto, token_ws, orden_compra, session_id, estado_transaccion, fecha_transaccion)
    VALUES
        (:id_certificado, :id_usuario, :monto, :token_ws, :orden_compra, :session_id, 'INICIADA', NOW())
");
$stmt->bindValue(':id_certificado', $idCertificado, PDO::PARAM_INT);
$stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
$stmt->bindValue(':monto', $monto, PDO::PARAM_INT);
$stmt->bindValue(':token_ws', $token, PDO::PARAM_STR);
$stmt->bindValue(':orden_compra', $buyOrder, PDO::PARAM_STR);
$stmt->bindValue(':session_id', $sessionId, PDO::PARAM_STR);
$stmt->execute();

/**
 * 9) Redirigir a Webpay (auto-submit)
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Redirigiendo a Webpay...</title>
</head>
<body>
    <p>Redirigiendo a Webpay, por favor espere...</p>
    <form action="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" method="POST" id="webpay_form">
        <input type="hidden" name="token_ws" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
        <noscript>
            <button type="submit">Ir a pagar</button>
        </noscript>
    </form>
    <script>
        document.getElementById('webpay_form').submit();
    </script>
</body>
</html>
