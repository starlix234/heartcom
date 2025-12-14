<?php
require_once __DIR__ . '/conexion.php';

function obtenerUsuarioPorRut($rut) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE rut = ?");
    $stmt->execute([$rut]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function crearCodigoMFA($id_usuario) {
    global $pdo;
    $codigo = random_int(100000, 999999);
    $expira = (new DateTime('+10 minutes'))->format('Y-m-d H:i:s');

    $stmt = $pdo->prepare("
        INSERT INTO codigos_mfa (id_usuario, codigo, tipo, expira_at)
        VALUES (?, ?, 'LOGIN', ?)
    ");
    $stmt->execute([$id_usuario, $codigo, $expira]);

    return $codigo;
}

function obtenerCodigoMFA($id_usuario, $codigo) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT id_codigo_mfa, expira_at, usado
        FROM codigos_mfa
        WHERE id_usuario = ? AND codigo = ? AND tipo = 'LOGIN'
        ORDER BY created_at DESC
        LIMIT 1
    ");
    $stmt->execute([$id_usuario, $codigo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function marcarCodigoUsado($id_codigo) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE codigos_mfa SET usado = 1 WHERE id_codigo_mfa = ?");
    $stmt->execute([$id_codigo]);
}

function enviarCorreoCodigo($correo, $codigo) {
    $asunto  = "Código de verificación";
    $mensaje = "Tu código es: $codigo";
    $header  = "From: no-reply@localhost\r\n";

    // En local puede devolver false, no importa por ahora
    mail($correo, $asunto, $mensaje, $header);
}
