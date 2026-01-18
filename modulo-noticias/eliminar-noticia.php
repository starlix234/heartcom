<?php
require_once '../lib/conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID inválido');
}

$stmt = $pdo->prepare("DELETE FROM noticias WHERE id_noticia = ?");
$stmt->execute([$_GET['id']]);

header("Location: listar.php");
exit;
