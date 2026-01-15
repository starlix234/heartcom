
<?php include("../lib/mostrar-reserva-admin.php")?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reservas</title>
</head>
<body>

<h2>Listado de reservas</h2>

<?php if (isset($_GET['msg'])): ?>
    <p style="color: green;">
        <?= htmlspecialchars($_GET['msg']) ?>
    </p>
<?php endif; ?>

<?php if (empty($reservas)): ?>
    <p>No hay reservas registradas.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Vecino</th>
                <th>Tipo</th>
                <th>Asunto</th>
                <th>Motivo</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reservas as $res): ?>
            <tr>
                <td><?= htmlspecialchars($res['nombre_completo']) ?></td>
                <td><?= htmlspecialchars($res['tipo']) ?></td>
                <td><?= htmlspecialchars($res['asunto']) ?></td>
                <td><?= htmlspecialchars($res['motivo']) ?></td>
                <td><?= htmlspecialchars($res['Fecha_ini']) ?></td>
                <td><?= htmlspecialchars($res['Fecha_fin']) ?></td>
                <td><?= htmlspecialchars($res['estado']) ?></td>
                <td>
                    <?php if (trim(strtolower($res['estado'])) == 'pendiente'): ?>

                        <!-- Botón Aprobar -->
                        <form action="../lib/procesar-reserva.php" method="post" style="display:inline;">
                            <input type="hidden" name="id_reserva" value="<?= (int)$res['id_reserva'] ?>">
                            <input type="hidden" name="accion" value="aprobar">
                            <button type="submit">Aprobar</button>
                        </form>

                        <!-- Botón Rechazar -->
                        <form action="../lib/procesar-reserva.php" method="post" style="display:inline;">
                            <input type="hidden" name="id_reserva" value="<?= (int)$res['id_reserva'] ?>">
                            <input type="hidden" name="accion" value="rechazar">
                            <button type="submit">Rechazar</button>
                        </form>
                    <?php else: ?>
                        Sin acciones
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
