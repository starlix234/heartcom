<?php
// Mostrar errores en pantalla para saber qué pasa
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("Error: Token no proporcionado.");
}

try {
    // Verificar token y expiración
    $stmt = $pdo->prepare("
        SELECT id_usuario 
        FROM usuarios 
        WHERE email_token = ? 
        AND email_token_expira > NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // HTML inicial
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verificación de Cuenta</title>
        <style>
            body{
                margin:0;
                min-height:100vh;
                display:flex;
                align-items:center;
                justify-content:center;
                background:#f6f7fb;
                font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            }
            .card{
                width:100%;
                max-width:450px;
                background:#fff;
                padding:30px 26px;
                border-radius:18px;
                box-shadow:0 14px 40px rgba(15,23,42,.08);
                text-align:center;
                padding:20px;
            }
            .icon{
                width:64px;
                height:64px;
                margin:0 auto 16px;
                border-radius:50%;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:32px;
                background:#ecfdf5;
                color:#059669;
            }
            h1{
                font-size:22px;
                margin-bottom:8px;
                color:#0f172a;
            }
            p{
                font-size:14px;
                color:#64748b;
                margin-bottom:22px;
            }
            a.btn{
                display:block;
                width:90%;
                padding:14px;
                border-radius:12px;
                text-decoration:none;
                font-weight:800;
                color:#fff;
                background:linear-gradient(180deg,#0b1020,#050814);
                box-shadow:0 14px 30px rgba(2,6,23,.25);
            }
            a.btn:hover{
                transform:translateY(-1px);
                box-shadow:0 18px 40px rgba(2,6,23,.32);
            }
            .error .icon{
                background:#fee2e2;
                color:#b91c1c;
            }
        </style>
    </head>
    <body>
    ';

    if (!$user) {
        // Token inválido o expirado
        echo '
        <div class="card error">
            <div class="icon">✖</div>
            <h1>Enlace inválido o expirado</h1>
            <p>Es posible que tu cuenta ya haya sido verificada o que el enlace haya caducado.</p>
            <a href="../login.php" class="btn">Ir al Login</a>
        </div>
        ';
        echo '</body></html>';
        exit;
    }

    // Activar usuario
    $update = $pdo->prepare("
        UPDATE usuarios 
        SET email_verificado = 1, 
            email_token = NULL, 
            email_token_expira = NULL 
        WHERE id_usuario = ?
    ");
    $update->execute([$user['id_usuario']]);

    // Éxito
    echo '
    <div class="card">
        <div class="icon">✓</div>
        <h1>¡Cuenta Verificada!</h1>
        <p>Tu correo ha sido confirmado correctamente. Ya puedes iniciar sesión.</p>
        <a href="../login.php" class="btn">Iniciar Sesión</a>
    </div>
    ';

    echo '</body></html>';

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
