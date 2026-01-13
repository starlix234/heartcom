<?php
require_once __DIR__ . '/conexion.php';

/**
 * Obtener usuario por RUT
 */
function obtenerUsuarioPorRut($rut) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            id_usuario,
            p_nombre,
            correo,
            rut,
            clave,
            email_verificado,
            id_rol
        FROM usuarios
        WHERE rut = ?
        LIMIT 1
    ");
    $stmt->execute([$rut]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Actualizar la clave del usuario a un hash seguro (password_hash)
 * Se usa cuando aún tenía la clave antigua en texto plano
 */
function actualizarClaveHasheada(int $id_usuario, string $nuevoHash): void {
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE usuarios
        SET clave = :hash
        WHERE id_usuario = :id
    ");
    $stmt->execute([
        ':hash' => $nuevoHash,
        ':id'   => $id_usuario,
    ]);
}

/**
 * Verificar la contraseña al iniciar sesión:
 * - Primero intenta con password_verify (hash).
 * - Si eso falla, permite claves antiguas en texto plano y las migra a hash.
 */
function verificarClaveLogin(string $claveIngresada, array $usuario): bool {
    $claveBd    = $usuario['clave'] ?? '';
    $id_usuario = (int)($usuario['id_usuario'] ?? 0);

    // 1) Caso normal: la clave en BD ya está hasheada (password_hash)
    if (password_verify($claveIngresada, $claveBd)) {
        return true;
    }

    // 2) Soporte para claves antiguas guardadas en texto plano
    //    (por ejemplo "1234", "12345"...)
    //    Solo si coincide EXACTO y la longitud no es rara
    if ($claveIngresada === $claveBd && strlen($claveBd) <= 50 && $id_usuario > 0) {
        // Migrar a hash seguro
        $nuevoHash = password_hash($claveIngresada, PASSWORD_DEFAULT);
        actualizarClaveHasheada($id_usuario, $nuevoHash);
        return true;
    }

    // 3) En cualquier otro caso: contraseña incorrecta
    return false;
}

/**
 * Crear código MFA
 */
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

/**
 * Obtener código MFA (último generado para ese usuario y código)
 */
function obtenerCodigoMFA($id_usuario, $codigo) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT id_codigo_mfa, expira_at, usado
        FROM codigos_mfa
        WHERE id_usuario = ? 
          AND codigo = ? 
          AND tipo = 'LOGIN'
        ORDER BY created_at DESC
        LIMIT 1
    ");
    $stmt->execute([$id_usuario, $codigo]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Marcar un código MFA como usado
 */
function marcarCodigoUsado($id_codigo) {
    global $pdo;

    $stmt = $pdo->prepare("
        UPDATE codigos_mfa 
        SET usado = 1 
        WHERE id_codigo_mfa = ?
    ");
    $stmt->execute([$id_codigo]);
}

/**
 * Enviar el código MFA por correo
 */
function enviarCorreoCodigo($correo, $codigo) {
    $asunto  = "Código de verificación";
    $mensaje = "Tu código es: $codigo";
    $header  = "From: no-reply@localhost\r\nContent-Type: text/plain; charset=UTF-8\r\n";

    // En local puede devolver false, no importa por ahora
    @mail($correo, $asunto, $mensaje, $header);
}
