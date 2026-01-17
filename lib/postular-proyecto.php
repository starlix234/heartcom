<?php
require_once("conexion.php");
session_start();

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../login.php?error=" . urlencode("Debes iniciar sesión para postular."));
  exit;
}

$id_usuario  = (int)$_SESSION['id_usuario'];
$id_proyecto = isset($_POST['id_proyecto']) ? (int)$_POST['id_proyecto'] : 0;

if ($id_proyecto <= 0) {
  header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Proyecto inválido."));
  exit;
}

try {
  $pdo->beginTransaction();

  // 1) Traer cupo actual dinámico y bloquear fila
  $stmt = $pdo->prepare("
    SELECT cupo_maximo
    FROM proyectos_barrio
    WHERE id_proyecto = ?
    FOR UPDATE
  ");
  $stmt->execute([$id_proyecto]);
  $proy = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$proy) {
    $pdo->rollBack();
    header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Proyecto no encontrado."));
    exit;
  }

  $cupo_actual = (int)$proy['cupo_maximo'];

  // 2) Validar cupos
  if ($cupo_actual <= 0) {
    $pdo->rollBack();
    header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("No quedan cupos disponibles."));
    exit;
  }

  // 3) Insertar postulación (pendiente = 1)
  //    IMPORTANTE: asegúrate que tu tabla se llame EXACTAMENTE postulaciones_proyecto
  $stmt = $pdo->prepare("
    INSERT INTO postulaciones_proyecto (id_usuario, id_proyecto, id_estado_postulacion)
    VALUES (?, ?, 1)
  ");
  $stmt->execute([$id_usuario, $id_proyecto]);

  // 4) Restar cupo dinámicamente (seguro)
  $stmt = $pdo->prepare("
    UPDATE proyectos_barrio
    SET cupo_maximo = cupo_maximo - 1
    WHERE id_proyecto = ? AND cupo_maximo > 0
  ");
  $stmt->execute([$id_proyecto]);

  if ($stmt->rowCount() !== 1) {
    // Si esto pasa, alguien se quedó con el último cupo justo antes
    $pdo->rollBack();
    header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Se agotaron los cupos. Intenta nuevamente."));
    exit;
  }

  $pdo->commit();

  header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Postulación enviada. Cupo reservado."));
  exit;

} catch (PDOException $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();

  // Duplicado por UNIQUE (id_usuario, id_proyecto)
  if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
    header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Ya estás postulada a este proyecto."));
    exit;
  }

  header("Location: ../modulo-proyecto/mis-postulaciones.php?msg=" . urlencode("Error al postular. Intenta nuevamente."));
  exit;
}
?>