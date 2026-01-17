<?php include('../lib/mis-postulaciones-proyecto.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
:root{
  --text:#111827;
  --muted:#6B7280;
  --line:#E5E7EB;
  --bg:#ffffff;
  --shadow: 0 10px 30px rgba(0,0,0,.06);
  --radius:14px;
}

*{ box-sizing: border-box; }

body{
  margin:0;
  font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  background:#F8FAFC;
  color:var(--text);
}

.wrap{
  max-width: 1100px;
  margin: 40px auto;
  padding: 0 16px;
}

.card{
  background:var(--bg);
  border:1px solid var(--line);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden; /* evita barras raras */
}

.card-header{
  padding:18px 20px;
  border-bottom:1px solid var(--line);
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:12px;
}

.card-header h2{
  margin:0;
  font-size:18px;
  font-weight:700;
  color:#374151;
}

.muted{
  color:var(--muted);
  font-size:12px;
  margin: 4px 0 0;
}

.table-wrap{
  width:100%;
  overflow-x: auto;     /* SOLO horizontal si hace falta */
  overflow-y: hidden;   /* NUNCA vertical */
  max-height: none;     /* por si el navegador inventa */
}

table{
  width:100%;
  border-collapse: collapse;

}

thead th{
  text-align:left;
  font-size:12px;
  letter-spacing:.04em;
  text-transform:uppercase;
  color: var(--muted);
  font-weight:700;
  padding:14px 16px;
  border-bottom:1px solid var(--line);
  background:#fff;
}

tbody td{
  padding:14px 16px;
  border-bottom:1px solid var(--line);
  font-size:14px;
  vertical-align:middle;
  overflow:hidden;
  text-overflow: ellipsis;
}

tbody tr:hover{ background:#FAFAFA; }

.name{ font-weight:700; }

/* deja que la descripción pueda bajar línea (y se ve menos “apretado”) */
.type{
  color:#374151;
  white-space: normal;
  line-height: 1.25;
}

/* Fechas cortitas y ordenadas */
.date{
  white-space: nowrap;
  color:#374151;
  font-variant-numeric: tabular-nums;
}

.badge{
  display:inline-flex;
  align-items:center;
  padding:6px 10px;
  border-radius: 999px;
  font-size:12px;
  font-weight:700;
  border:1px solid transparent;
  white-space: nowrap;
}

.badge-pendiente{ color:#374151; background:#F3F4F6; border-color:#E5E7EB; }
.badge-revision{ color:#1D4ED8; background:#DBEAFE; border-color:#BFDBFE; }
.badge-aprobado{ color:#065F46; background:#D1FAE5; border-color:#A7F3D0; }
.badge-rechazado{ color:#991B1B; background:#FEE2E2; border-color:#FECACA; }

.empty{
  padding:18px 20px;
  color:#6B7280;
}

/* --------- Anchos por columna (table-layout: fixed) --------- */
th:nth-child(1), td:nth-child(1){ width: 200px; } /* Proyecto */
th:nth-child(2), td:nth-child(2){ width: 360px; } /* Descripción */
th:nth-child(3), td:nth-child(3){ width: 110px; } /* Inicio */
th:nth-child(4), td:nth-child(4){ width: 110px; } /* Fin */
th:nth-child(5), td:nth-child(5){ width: 160px; } /* Postulación */
th:nth-child(6), td:nth-child(6){ width: 120px; } /* Estado */
th:nth-child(7), td:nth-child(7){ width: 150px; } /* Respuesta */
th:nth-child(8), td:nth-child(8){ width: 260px; } /* Observación */

/* Responsive: en pantallas chicas sí o sí necesitarás scroll horizontal */
@media (max-width: 900px){
  table{ min-width: 980px; } /* SOLO para móvil/tablet */
  .card-header{ flex-direction: column; }
}


  </style>

    <title>Mis Postulaciones</title>
</head>

<body>
  <main class="wrap">
    <section class="card">
      <header class="card-header">
        <div>
          <h2>Mis postulaciones</h2>
          <p class="muted">Revisa el estado y la respuesta del administrador para cada proyecto.</p>
        </div>
      </header>

      <div class="table-wrap">
        <?php if (!empty($postulaciones)): ?>
          <table>
            <thead>
              <tr>
                <th>Proyecto</th>
                <th>Descripción</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Postulación</th>
                <th>Estado</th>
                <th>Respuesta</th>
                <th>Observación</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($postulaciones as $p): ?>
                <?php
                  // Normalizamos el estado para decidir el badge
                  $estadoRaw = strtolower(trim($p['nombre_estado'] ?? 'pendiente'));

                  // Mapeo flexible (por si tu BD usa variaciones)
                  $badgeClass = 'badge-pendiente';
                  if (str_contains($estadoRaw, 'revision') || str_contains($estadoRaw, 'revisión') || str_contains($estadoRaw, 'proceso')) {
                    $badgeClass = 'badge-revision';
                  } elseif (str_contains($estadoRaw, 'aprob')) {
                    $badgeClass = 'badge-aprobado';
                  } elseif (str_contains($estadoRaw, 'rechaz') || str_contains($estadoRaw, 'deneg')) {
                    $badgeClass = 'badge-rechazado';
                  }

                  $fechaResp = $p['fecha_respuesta'] ?? '';
                  $obs = $p['observacion_admin'] ?? '';
                ?>
                <tr>
                  <td class="name"><?= htmlspecialchars($p['nombre_proyecto'] ?? '') ?></td>
                  <td class="type" title="<?= htmlspecialchars($p['descripcion'] ?? '') ?>">
                    <?= htmlspecialchars($p['descripcion'] ?? '') ?>
                  </td>
                  <td class="date"><?= htmlspecialchars($p['fecha_inicio'] ?? '') ?></td>
                  <td class="date"><?= htmlspecialchars($p['fecha_fin'] ?? '') ?></td>
                  <td class="date"><?= htmlspecialchars($p['fecha_postulacion'] ?? '') ?></td>
                  <td>
                    <span class="badge <?= $badgeClass ?>">
                      <?= htmlspecialchars($p['nombre_estado'] ?? 'Pendiente') ?>
                    </span>
                  </td>
                  <td class="date">
                    <?= $fechaResp ? htmlspecialchars($fechaResp) : '—' ?>
                  </td>
                  <td class="type" title="<?= htmlspecialchars($obs) ?>">
                    <?= $obs ? htmlspecialchars($obs) : '—' ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="empty">No tienes postulaciones registradas.</div>
        <?php endif; ?>
      </div>
    </section>
  </main>
</body>
</html>