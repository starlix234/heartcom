<?php include("../lib/listar-tipo-reserva.php")?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear reserva</title>
</head>
<body>
<form action="../lib/guardar-reserva.php" method="POST">
  <label>Tipo de reserva</label>
  <select name="id_tipo" required>
    <option value="">Seleccione</option>

    <?php foreach ($tipos as $t): ?>
      <option value="<?= $t['id_tipo'] ?>">
        <?= htmlspecialchars($t['tipo']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <br><br>

  <label>Fecha inicio</label>
  <input type="date" name="fecha_ini" required>

  <br><br>

  <label>Fecha fin</label>
  <input type="date" name="fecha_fin" required>

  <br><br>

  <label>Asunto</label>
  <input type="text" name="asunto" required>

  <br><br>

  <label>Motivo</label>
  <textarea name="motivo"></textarea>

  <br><br>

  <button type="submit">Enviar reserva</button>

</form>

</body>
</html>
