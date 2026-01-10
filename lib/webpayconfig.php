<?php
// Ambiente: integración (pruebas)
define('WEBPAY_BASE_URL', 'https://webpay3gint.transbank.cl'); // integración
// Producción sería: https://webpay3g.transbank.cl

// Credenciales de integración (las que pegaste)
define('WEBPAY_API_KEY_ID', '597055555532');
define('WEBPAY_API_KEY_SECRET', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');

// Ruta API Webpay Plus
define('WEBPAY_TX_ENDPOINT', '/rswebpaytransaction/api/webpay/v1.2/transactions');
