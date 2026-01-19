<?php
// lib/actualizar-postulaciones.php
require_once(__DIR__ . "/conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("Metodo no permitido.");
}

$id_postulacion = filter_input(INPUT_POST, 'id_postulacion', FILTER_VALIDATE_INT);
$id_estado      = filter_input(INPUT_POST, 'id_estado_postulacion', FILTER_VALIDATE_INT);
$obs            = trim($_POST['observacion_admin'] ?? '');

if (!$id_postulacion || !$id_estado) {
  die("Datos invalidos.");
}

/** ====== CONFIG (ajusta si tus ids son distintos) ====== */
$ID_PENDIENTE = 1;
$ID_ACEPTADA  = 2;

/** ====== Validar que el estado exista ====== */
$stCheck = $pdo->prepare("SELECT 1 FROM estados_postulacion WHERE id_estado_postulacion = :id");
$stCheck->execute([':id' => $id_estado]);

if (!$stCheck->fetchColumn()) {
  die("Estado no existe.");
}

/** ====== Traer cupos para bloquear aceptacion si esta lleno ====== */
$sqlInfo = "SELECT
              p.id_proyecto,
              pb.cupo_maximo,
              COALESCE(a.aceptados, 0) AS cupos_usados
            FROM postulaciones_proyecto p
            JOIN proyectos_barrio pb ON pb.id_proyecto = p.id_proyecto
            LEFT JOIN (
              SELECT id_proyecto, COUNT(*) AS aceptados
              FROM postulaciones_proyecto
              WHERE id_estado_postulacion = :id_aceptada
              GROUP BY id_proyecto
            ) a ON a.id_proyecto = p.id_proyecto
            WHERE p.id_postulacion = :id_postulacion
            LIMIT 1";

$stInfo = $pdo->prepare($sqlInfo);
$stInfo->execute([
  ':id_aceptada'     => $ID_ACEPTADA,
  ':id_postulacion'  => $id_postulacion
]);

$info = $stInfo->fetch(PDO::FETCH_ASSOC);

if (!$info) {
  die("Postulacion no encontrada.");
}

/** ====== Regla: no aceptar si cupo lleno ====== */
$cuposLlenos = ((int)$info['cupos_usados'] >= (int)$info['cupo_maximo']);

if ((int)$id_estado === $ID_ACEPTADA && $cuposLlenos) {
  header("Location: ../modulo-proyecto/detalle-postulacion.php?id_postulacion=".$id_postulacion
        ."&msg=".urlencode("No se puede aceptar: cupo lleno."));
  exit;
}

/** ====== fecha_respuesta automatica ====== */
$fecha_respuesta = ((int)$id_estado === $ID_PENDIENTE) ? null : date('Y-m-d H:i:s');

/** ====== UPDATE (sin placeholders repetidos) ====== */
$sqlUp = "UPDATE postulaciones_proyecto
          SET id_estado_postulacion = :estado,
              observacion_admin = :obs,
              fecha_respuesta = :fecha
          WHERE id_postulacion = :id";

$stUp = $pdo->prepare($sqlUp);
$stUp->execute([
  ':estado' => $id_estado,
  ':obs'    => ($obs === '' ? null : $obs),
  ':fecha'  => $fecha_respuesta,
  ':id'     => $id_postulacion
]);

header("Location: ../modulo-proyecto/detalle-postulacion.php?id_postulacion=".$id_postulacion
      ."&msg=".urlencode("Postulacion actualizada."));
exit;
