<?php
// lib/procesar-proyecto.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/conexion.php"; // aquí vive $pdo
require_once __DIR__ . "/roles.php";    // aquí vive $rol

// Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../modulo-proyecto/proyectos.php?error=acceso_invalido");
    exit;
}

// Sesión obligatoria
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit;
}

// Permisos (1 Moderador, 2 Jefe)
$rol = isset($rol) ? (int)$rol : 0;
if (!in_array($rol, [1, 2], true)) {
    header("Location: ../panel.php?error=sin_permiso");
    exit;
}

// Leer POST
$id_proyecto = (int)($_POST['id_proyecto'] ?? 0);
$accion = trim($_POST['accion'] ?? '');

if ($id_proyecto <= 0 || !in_array($accion, ['aprobar', 'rechazar'], true)) {
    header("Location: ../modulo-proyecto/proyectos.php?error=datos_invalidos");
    exit;
}

// Estados reales según tu tabla:
// 5 = Aprobado | 6 = Rechazado
$nuevo_estado = ($accion === 'aprobar') ? 5 : 6;

try {
    // Solo cambia si está Planificado (1)
    $sql = "UPDATE proyectos_barrio
            SET id_estado_proyecto = :nuevo_estado
            WHERE id_proyecto = :id_proyecto
              AND id_estado_proyecto = 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nuevo_estado' => $nuevo_estado,
        ':id_proyecto'  => $id_proyecto
    ]);

    if ($stmt->rowCount() > 0) {
        header("Location: ../modulo-proyecto/proyectos.php?ok=1");
        exit;
    }

    header("Location: ../modulo-proyecto/proyectos.php?error=no_actualizo");
    exit;

} catch (Throwable $e) {
    header("Location: ../modulo-proyecto/proyectos.php?error=sql");
    exit;
}
