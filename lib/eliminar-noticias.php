<?php
session_start();
require_once '../lib/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die('Acceso no autorizado');
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die('ID inválido');
}

$stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?");
$stmt->execute([$_POST['id']]);

if ($stmt->rowCount() === 0) {
    die('La noticia no existe');
}

header("Location: listar.php?msg=eliminado");
exit;
