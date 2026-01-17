<?php include("../lib/listar-tipo-reserva.php")?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crear reserva</title>

  <!-- Tu CSS -->
  <link rel="stylesheet" href="../assets/css/estilo-dashboard-formulario.css" />
</head>
<body>

  <main class="page">
    <section class="card">
      <header class="card__header">
        <div class="card__icon" aria-hidden="true">
          <!-- ícono tipo calendario/reserva -->
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
            <path d="M8 2v3M16 2v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M3 9h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M6 4h12a3 3 0 0 1 3 3v13a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3Z" stroke="currentColor" stroke-width="2" />
            <path d="M8 13h2M12 13h2M16 13h0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>

        <div>
          <h1 class="card__title">Crear Reserva</h1>
          <p class="card__subtitle">Complete el formulario para registrar una nueva reserva.</p>
        </div>
      </header>

      <form class="form" action="../lib/guardar-reserva.php" method="POST">

        <!-- Tipo -->
        <div class="field">
          <label class="label" for="id_tipo">Seleccione un tipo de reserva</label>

          <div class="select-wrap">
            <select class="control control--select" name="id_tipo" id="id_tipo" required>
              <option value="">Seleccione</option>
              <?php foreach ($tipos as $t): ?>
                <option value="<?= (int)$t['id_tipo'] ?>">
                  <?= htmlspecialchars($t['tipo']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <span class="select-caret" aria-hidden="true">˅</span>
          </div>
        </div>

        <!-- Fecha inicio -->
        <div class="field">
          <label class="label" for="fecha_ini">Fecha inicio</label>
          <input class="control" type="date" name="fecha_ini" id="fecha_ini" required />
        </div>

        <!-- Fecha fin -->
        <div class="field">
          <label class="label" for="fecha_fin">Fecha fin</label>
          <input class="control" type="date" name="fecha_fin" id="fecha_fin" required />
        </div>

        <!-- Asunto -->
        <div class="field">
          <label class="label" for="asunto">Asunto</label>
          <input
            class="control"
            type="text"
            name="asunto"
            id="asunto"
            placeholder="Ingrese el asunto de su reserva"
            required
          />
        </div>

        <!-- Motivo -->
        <div class="field">
          <label class="label" for="motivo">Motivo</label>
          <textarea
            class="control control--textarea"
            name="motivo"
            id="motivo"
            placeholder="Ingrese el motivo de la reserva (opcional)"
          ></textarea>
        </div>

        <button class="btn" type="submit">Enviar reserva</button>
      </form>

    </section>
  </main>

</body>
</html>
