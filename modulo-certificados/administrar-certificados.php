<?php include("lib/listar-certificado.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h2>Solicitudes de Certificados</h2>

<table border="1">
<tr>
    <th>Vecino</th>
    <th>RUT</th>
    <th>Asunto</th>
    <th>Mensaje</th>
    <th>Acción</th>
</tr>

<?php foreach ($solicitudes as $s): ?>
<tr>
    <td><?= $s['nombre'] . ' ' . $s['apellido'] ?></td>
    <td><?= $s['rut'] ?></td>
    <td><?= $s['asunto'] ?></td>
    <td><?= $s['mensaje'] ?></td>
    <td>
        <form method="POST" action="lib/gestionar_solicitud.php">
            <input type="hidden" name="id_certificado" value="<?= $s['id_certificado'] ?>">
            <button name="accion" value="aprobar">Aprobar</button>
            <button name="accion" value="rechazar">Rechazar</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>