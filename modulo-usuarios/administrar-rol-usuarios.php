<?php
include("../lib/mostrar-usuario.php");
include("../lib/permisos-admin.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Usuarios y Roles - HeartCom</title>

  <link rel="stylesheet" href="../assets/css/estilo-dashboard-usuarios.css">

  <!-- Tipografía + íconos -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

  <aside class="sidebar">
    <h2>HeartCom</h2>

    <nav>
      <a href="#" class="menu-item active">
        <i class="fa-solid fa-users"></i> Usuarios
      </a>  
      <div style="height:18px;"></div>

      <a href="../index.php" class="menu-item">
        <i class="fa-solid fa-right-from-bracket"></i> Volver
      </a>
    </nav>
  </aside>

  <main class="main-content">

    <header>
      <div class="title">
        <h1>Usuarios y roles</h1>
        <p>Administra roles sin drama: dos clics y listo.</p>
      </div>
    </header>

    <?php if (!empty($_GET['msg'])): ?>
      <div class="alert success">
        ✅ <?= htmlspecialchars($_GET['msg']) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
      <div class="alert error">
        ❌ <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>

    <section class="panel">
      <div class="panel-head">
        <div>
          <h3>Usuarios registrados</h3>
          <p>Aquí ves todo el roster. Cambias el rol y el sistema obedece.</p>
        </div>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th style="width:80px;">#</th>
              <th>Nombre completo</th>
              <th style="width:150px;">RUT</th>
              <th>Correo</th>
              <th style="width:160px;">Rol actual</th>
              <th style="width:360px;">Cambiar rol</th>
            </tr>
          </thead>

          <tbody>
          <?php if (empty($usuarios)): ?>
            <tr>
              <td colspan="6" class="text-muted">No hay usuarios registrados.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
              <tr>
                <td><?= (int)$u['id_usuario'] ?></td>

                <td>
                  <?= htmlspecialchars(
                    trim(
                      ($u['p_nombre'] ?? '') . ' ' .
                      ($u['s_nombre'] ?? '') . ' ' .
                      ($u['ap_paterno'] ?? '') . ' ' .
                      ($u['ap_materno'] ?? '')
                    )
                  ) ?>
                </td>

                <td><?= htmlspecialchars($u['rut'] ?? '') ?></td>
                <td><?= htmlspecialchars($u['correo'] ?? '') ?></td>

                <td>
                  <span class="badge">
                    <?= htmlspecialchars($u['nombre_rol'] ?? 'Sin rol') ?>
                  </span>
                </td>

                <td>
                  <form action="../lib/actualizar-rol-usuario.php" method="post" class="role-form">
                    <input type="hidden" name="id_usuario" value="<?= (int)$u['id_usuario'] ?>">

                    <select name="id_rol" required>
                      <option value="">-- Seleccionar rol --</option>
                      <?php foreach ($roles as $rol): ?>
                        <option
                          value="<?= (int)$rol['id_rol'] ?>"
                          <?= ((int)$rol['id_rol'] === (int)$u['id_rol']) ? 'selected' : '' ?>
                        >
                          <?= htmlspecialchars($rol['nombre_rol']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>

                    <button type="submit">
                      <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>

</body>
</html>
