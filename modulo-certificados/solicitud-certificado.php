<?php
require("../lib/leer-tipo-certificado.php");
session_start(); // por si no estaba arriba en tu proyecto
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/css/estilo-dashboard-formulario.css" />
  <title>Solicitar Certificado</title>
</head>
<body>

  <main class="page">
    <section class="card">
      <header class="card__header">
        <div class="card__icon" aria-hidden="true">
          <!-- ícono tipo documento -->
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
            <path d="M7 3h7l3 3v15a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M14 3v4a2 2 0 0 0 2 2h4" stroke="currentColor" stroke-width="1.8"/>
            <path d="M8 12h8M8 16h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </div>

        <div>
          <h1 class="card__title">Solicitar Certificado</h1>
          <p class="card__subtitle">Complete el formulario para solicitar un certificado</p>
        </div>
      </header>

      <form action="lib/insertar-certificado.php" method="post" class="form">

        <div class="field">
          <label class="label" for="asunto">Asunto</label>
          <input
            type="text"
            name="asunto"
            id="asunto"
            class="control"
            placeholder="Ingrese el asunto de su solicitud"
            required
          />
        </div>

        <div class="field">
          <label class="label" for="id_certi">Seleccione un certificado:</label>
          <div class="select-wrap">
            <select name="id_certi" id="id_certi" class="control control--select" required>
              <option value="">Seleccione un certificado</option>
              <?php foreach ($tiposCertificados as $cert): ?>
                <option value="<?= (int)$cert['id_certi'] ?>">
                  <?= htmlspecialchars($cert['nombre_certificado']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <span class="select-caret" aria-hidden="true">⌄</span>
          </div>
        </div>

        <div class="field">
          <label class="label" for="mensaje">Motivo de la solicitud</label>
          <textarea
            name="mensaje"
            id="mensaje"
            class="control control--textarea"
            rows="4"
            placeholder="Ingrese el motivo del porque desea solicitar este certificado o permiso"
            required
          ></textarea>
        </div>

        <input
          type="hidden"
          name="id_usuario"
          id="id_usuario"
          value="<?= htmlspecialchars($_SESSION['id_usuario'] ?? '') ?>"
          readonly
        />

        <button class="btn" type="submit">
          Enviar Solicitud
        </button>

      </form>
    </section>
  </main>

</body>
</html>
