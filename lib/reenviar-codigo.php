<?php
// reenviar_codigo.php
session_start();

if (!isset($_SESSION['pending_mfa_user'])) {
  header("Location: login.php");
  exit;
}

require_once __DIR__ . "/lib/conexion.php"; // ajusta ruta a tu conexion (PDO/MySQLi)

// Si en sesión guardas un array, ajusta: $id_usuario = $_SESSION['pending_mfa_user']['id_usuario'];
$id_usuario = (int)$_SESSION['pending_mfa_user'];

// 1) Generar código nuevo
$codigo = (string)random_int(100000, 999999);

// 2) Guardar/actualizar en BD
// EJEMPLO de tabla: codigos_mfa(id_usuario, codigo, expira_en, usado, creado_en)
// Ajusta nombres según tu tabla real:
$expira_en = date("Y-m-d H:i:s", time() + 10 * 60); // 10 minutos

try {
  // Si usas PDO:
  // - Opcional: invalidar códigos previos del usuario
  $stmt = $pdo->prepare("UPDATE codigos_mfa SET usado = 1 WHERE id_usuario = ?");
  $stmt->execute([$id_usuario]);

  // Insert nuevo
  $stmt = $pdo->prepare("INSERT INTO codigos_mfa (id_usuario, codigo, expira_en, usado, creado_en)
                         VALUES (?, ?, ?, 0, NOW())");
  $stmt->execute([$id_usuario, $codigo, $expira_en]);

} catch (Throwable $e) {
  header("Location: verificar_codigo.php?error=" . urlencode("No se pudo generar el código. Intenta nuevamente."));
  exit;
}

// 3) Obtener correo del usuario
try {
  $stmt = $pdo->prepare("SELECT correo, p_nombre FROM usuarios WHERE id_usuario = ? LIMIT 1");
  $stmt->execute([$id_usuario]);
  $u = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$u || empty($u['correo'])) {
    header("Location: verificar_codigo.php?error=" . urlencode("No se encontró correo para reenviar el código."));
    exit;
  }

  $correo = $u['correo'];
  $nombre = $u['p_nombre'] ?? 'Usuario';

} catch (Throwable $e) {
  header("Location: verificar_codigo.php?error=" . urlencode("No se pudo obtener el correo del usuario."));
  exit;
}

// 4) Enviar correo (base con mail())
// Si tienes PHPMailer, dime y lo dejamos profesional SMTP.
$subject = "Tu código de verificación - HeartCom";
$message = "Hola $nombre,\n\nTu código de verificación es: $codigo\n\nVence en 10 minutos.\n\nSi no fuiste tú, ignora este mensaje.";
$headers = "From: HeartCom <no-reply@heartcom.cl>\r\n" .
           "Content-Type: text/plain; charset=UTF-8\r\n";

@mail($correo, $subject, $message, $headers);

// 5) Volver a la pantalla
header("Location: verificar_codigo.php?ok=" . urlencode("Código reenviado. Revisa tu correo."));
exit;
