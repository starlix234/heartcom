<?php include("lib/listar-certificado.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Certificados</title>
</head>
<body>
    
<h2>Solicitudes de Certificados</h2>

<table border="1">
    <thead>
        <tr> 
            <th>Vecino</th>
            <th>RUT</th>
            <th>Asunto</th>
            <th>Mensaje</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($solicitudes as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['nombre'] . ' ' . $s['apellido']) ?></td>
            <td><?= htmlspecialchars($s['rut']) ?></td>
            <td><?= htmlspecialchars($s['asunto']) ?></td>
            <td><?= nl2br(htmlspecialchars($s['mensaje'])) ?></td>
            <td><?= htmlspecialchars($s['estado']) ?></td>
            <td>
                <form method="POST" action="lib/gestionar-solicitud.php">
                    <!-- datos que necesita el backend, pero ocultos -->
                    <input type="hidden" name="id_certificado" value="<?= (int)$s['id_certificado'] ?>">
                    <input type="hidden" name="correo" value="<?= htmlspecialchars($s['correo']) ?>">
                    <input type="hidden" name="nombre" value="<?= htmlspecialchars($s['nombre']) ?>">

                    <button type="submit" name="accion" value="aprobar">Aprobar</button>
                    <button type="submit" name="accion" value="rechazar">Rechazar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
