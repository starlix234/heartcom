<?php
// verificar_codigo.php
session_start();

if (!isset($_SESSION['pending_mfa_user'])) {
    header("Location: login.php");
    exit;
}

$ok = $_GET['ok'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificar código</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --blue:#3B5BFF;
      --blue2:#2F49FF;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e5e7eb;
      --bg:#ffffff;
      --shadow: 0 18px 55px rgba(15, 23, 42, .14);
      --radius:18px;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:#f6f7fb;
      color:var(--text);
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px 16px;
    }

    .card{
      width:min(520px, 100%);
      background:var(--bg);
      border-radius:24px;
      box-shadow: var(--shadow);
      padding:34px 28px 26px;
      border:1px solid rgba(226,232,240,.7);
      text-align:center;
    }

    .icon-wrap{
      width:78px;
      height:78px;
      margin: 0 auto 14px;
      border-radius:50%;
      background: radial-gradient(circle at 30% 30%, #6D86FF 0%, var(--blue) 55%, var(--blue2) 100%);
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 16px 28px rgba(59,91,255,.35);
    }

    .icon-wrap svg{ color:white; }

    h1{
      margin: 8px 0 10px;
      font-size: 30px;
      line-height:1.15;
      color: var(--blue);
      letter-spacing:.2px;
      font-weight:800;
    }

    .sub{
      margin:0 0 18px;
      color: var(--muted);
      font-size: 14px;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
    }

    .sub .mail{
      width:18px; height:18px; opacity:.85;
    }

    .alert{
      margin: 0 0 14px;
      padding: 10px 12px;
      border-radius: 12px;
      font-size: 13px;
      text-align:left;
      border:1px solid transparent;
    }
    .alert.ok{
      color:#065f46;
      background:#d1fae5;
      border-color:#a7f3d0;
    }
    .alert.err{
      color:#991b1b;
      background:#fee2e2;
      border-color:#fecaca;
    }

    .label{
      width:100%;
      text-align:left;
      margin: 6px 0 8px;
      font-size: 14px;
      font-weight:700;
      color:#0f172a;
    }

    .input{
      width:100%;
      padding: 14px 16px;
      border-radius: 12px;
      border: 1px solid var(--line);
      background:#f3f4f6;
      outline:none;
      font-size: 15px;
      text-align:center;
      letter-spacing: .22em;
      font-weight:700;
      transition: .15s ease;
    }
    .input:focus{
      background:#fff;
      border-color:#c7d2fe;
      box-shadow: 0 0 0 4px rgba(59,91,255,.12);
    }

    .hint{
      margin: 10px 0 18px;
      font-size: 13px;
      color: var(--muted);
    }

    .btn{
      width:100%;
      border:0;
      cursor:pointer;
      padding: 14px 16px;
      border-radius: 12px;
      font-weight:800;
      color:#fff;
      background: linear-gradient(180deg, #4D6BFF 0%, #2F49FF 100%);
      box-shadow: 0 14px 26px rgba(59,91,255,.28);
      transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 18px 34px rgba(59,91,255,.35); }
    .btn:active{ transform: translateY(0); opacity:.96; }

    .resend-wrap{
      margin-top: 16px;
      font-size: 13px;
      color: var(--muted);
    }

    .resend{
      display:inline-block;
      margin-top: 10px;
      background: transparent;
      border:0;
      color: var(--blue);
      font-weight:800;
      cursor:pointer;
      text-decoration:none;
    }
    .resend:hover{ text-decoration: underline; }

    @media (max-width: 420px){
      h1{ font-size: 26px; }
      .card{ padding: 30px 18px 22px; }
    }
  </style>
</head>

<body>
  <div class="card">

    <div class="icon-wrap" aria-hidden="true">
      <!-- escudo -->
      <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
        <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4Z" stroke="currentColor" stroke-width="1.8" />
        <path d="M9.5 12.2l1.6 1.6 3.6-3.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <h1>Verificación de código</h1>

    <p class="sub">
      <svg class="mail" viewBox="0 0 24 24" fill="none">
        <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.6"/>
        <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Se ha enviado un código de verificación a tu correo
    </p>

    <?php if ($ok): ?>
      <div class="alert ok"><?= htmlspecialchars($ok) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="procesar_codigo.php" method="POST">
      <div class="label">Código:</div>
      <input class="input" type="text" name="codigo" maxlength="8" inputmode="numeric" autocomplete="one-time-code"
             placeholder="Ingresa tu código" required>

      <div class="hint">Revisa tu bandeja de entrada y carpeta de spam</div>

      <button class="btn" type="submit">Confirmar</button>
    </form>

    <div class="resend-wrap">
      ¿No recibiste el código?<br>
      <form action="reenviar_codigo.php" method="POST" style="margin:0;">
        <button class="resend" type="submit">Reenviar código</button>
      </form>
    </div>

  </div>
</body>
</html>
