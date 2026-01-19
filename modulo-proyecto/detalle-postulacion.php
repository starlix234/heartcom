<?php
require_once(__DIR__ . "/../lib/conexion.php");

$id_postulacion = filter_input(INPUT_GET, 'id_postulacion', FILTER_VALIDATE_INT);
if (!$id_postulacion) { die("ID inválido."); }

// Detalle (usa lo que ya tienes en tu SELECT grande, pero acotado a 1)
$sql = "SELECT
          p.id_postulacion, p.fecha_postulacion, p.fecha_respuesta,
          p.id_estado_postulacion, ep.nombre_estado AS estado_postulacion,
          p.observacion_admin,
          pb.id_proyecto, pb.nombre_proyecto, pb.cupo_maximo,
          CONCAT_WS(' ', u.p_nombre, u.s_nombre, u.ap_paterno, u.ap_materno) AS postulante,
          COALESCE(a.aceptados, 0) AS cupos_usados
        FROM postulaciones_proyecto p
        JOIN proyectos_barrio pb ON pb.id_proyecto = p.id_proyecto
        JOIN estados_postulacion ep ON ep.id_estado_postulacion = p.id_estado_postulacion
        JOIN usuarios u ON u.id_usuario = p.id_usuario
        LEFT JOIN (
          SELECT id_proyecto, COUNT(*) AS aceptados
          FROM postulaciones_proyecto
          WHERE id_estado_postulacion = 2
          GROUP BY id_proyecto
        ) a ON a.id_proyecto = p.id_proyecto
        WHERE p.id_postulacion = :id
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_postulacion]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) { die("Postulación no encontrada."); }

// Estados para el select
$estados = $pdo->query("SELECT id_estado_postulacion, nombre_estado
                        FROM estados_postulacion
                        ORDER BY id_estado_postulacion")
              ->fetchAll(PDO::FETCH_ASSOC);

function badgeClass($estadoId){
  return match((int)$estadoId){
    1 => 'bg-primary',   // pendiente
    2 => 'bg-success',   // aceptada
    3 => 'bg-danger',    // rechazada
    default => 'bg-secondary'
  };
}

$cuposLlenos = ((int)$post['cupos_usados'] >= (int)$post['cupo_maximo']);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar Postulación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Administrar Postulación</h2>
    <a class="btn btn-outline-secondary" href="proyectos.php">Volver</a>
  </div>

  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <div class="text-muted small">Postulante</div>
          <div class="fw-semibold"><?= htmlspecialchars($post['postulante']) ?></div>
        </div>
        <div class="col-md-6">
          <div class="text-muted small">Proyecto</div>
          <div class="fw-semibold"><?= htmlspecialchars($post['nombre_proyecto']) ?></div>
        </div>

        <div class="col-md-4">
          <div class="text-muted small">Estado actual</div>
          <span class="badge <?= badgeClass($post['id_estado_postulacion']) ?>">
            <?= htmlspecialchars($post['estado_postulacion']) ?>
          </span>
        </div>
        <div class="col-md-4">
          <div class="text-muted small">Fecha postulación</div>
          <div><?= htmlspecialchars($post['fecha_postulacion']) ?></div>
        </div>
        <div class="col-md-4">
          <div class="text-muted small">Fecha respuesta</div>
          <div><?= $post['fecha_respuesta'] ? htmlspecialchars($post['fecha_respuesta']) : '—' ?></div>
        </div>

        <div class="col-md-12">
          <div class="text-muted small">Cupos</div>
          <div class="d-flex align-items-center gap-2">
            <span class="badge <?= $cuposLlenos ? 'bg-danger' : 'bg-dark' ?>">
              <?= (int)$post['cupos_usados'] ?> / <?= (int)$post['cupo_maximo'] ?>
            </span>
            <?php if ($cuposLlenos): ?>
              <span class="text-danger small">Cupo lleno: si aceptas otro, rompes la física.</span>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <hr>

      <form method="POST" action="../lib/actualizar-postulaciones.php" class="row g-3">
        <input type="hidden" name="id_postulacion" value="<?= (int)$post['id_postulacion'] ?>">

        <div class="col-md-4">
          <label class="form-label">Cambiar estado</label>
          <select name="id_estado_postulacion" class="form-select" required>
            <?php foreach ($estados as $e): ?>
              <option value="<?= (int)$e['id_estado_postulacion'] ?>"
                <?= ((int)$e['id_estado_postulacion'] === (int)$post['id_estado_postulacion']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['nombre_estado']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Si pones “Aceptada” y el cupo está lleno, lo bloqueamos abajo.</div>
        </div>

        <div class="col-12">
          <label class="form-label">Observación admin</label>
          <textarea name="observacion_admin" class="form-control" rows="4"
            placeholder="Ej: Aprobada, presentarse el lunes..."><?= htmlspecialchars($post['observacion_admin'] ?? '') ?></textarea>
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <a class="btn btn-outline-secondary" href="administrar-postulaciones.php">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

</div>
</body>
</html>
