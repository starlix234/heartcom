<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../lib/mostrar-noticia.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias del Barrio</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    :root{
      /* FONDO AZUL MÁS OSCURO */
      --bg-blue: linear-gradient(135deg, #c7dbff, #a9c3ff);
      --card: #ffffff;
      --text: #0f172a;
      --muted: #64748b;
      --line: #e5e7eb;
      --control: #f3f4f6;
      --shadow: 0 18px 45px rgba(15,23,42,.12);
      --radius: 18px;
    }

    /* RESET */
    *{
      box-sizing: border-box;
    }

    /* BODY */
    body{
      margin:0;
      min-height:100vh;
      background: var(--bg-blue);
      font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont;
      color: var(--text);
    }

    /* CONTENEDOR GENERAL */
    .container{
      padding-top:40px;
      padding-bottom:40px;
    }

    /* TITULO */
    h2{
      font-weight:800;
    }

    /* CARD NOTICIA */
    .card-noticia{
      border-radius: var(--radius);
      border: 1px solid var(--line);
      box-shadow: var(--shadow);
      overflow: hidden;
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .card-noticia:hover{
      transform: translateY(-4px);
      box-shadow: 0 24px 55px rgba(15,23,42,.18);
    }

    /* IMAGEN */
    .card-noticia img{
      height: 200px;
      object-fit: cover;
    }

    /* CARD BODY */
    .card-body{
      display:flex;
      flex-direction:column;
    }

    /* TITULO CARD */
    .card-title{
      font-weight:700;
      font-size:1.1rem;
    }

    /* BADGE */
    .badge{
      width: fit-content;
      font-size:12px;
      padding:6px 10px;
      border-radius:10px;
    }

    /* FECHA */
    .text-muted{
      font-size:13px;
    }

    /* BOTONES */
    .btn{
      border-radius:12px;
      font-weight:600;
    }

    .btn-primary{
      box-shadow: 0 8px 18px rgba(13,110,253,.25);
    }

    .btn-warning{
      font-weight:700;
    }

    .btn-danger{
      font-weight:700;
    }

    /* RESPONSIVE */
    @media(max-width:576px){
      h2{
        font-size:1.4rem;
      }
    }
    </style>
</head>

<body>

<div class="container">

    <div class="d-flex align-items-center mb-4">

    <!-- TÍTULO (queda fijo a la izquierda) -->
    <h2 class="me-auto">📰 Noticias del Barrio</h2>

    <!-- GRUPO DE BOTONES -->
    <div class="d-flex gap-2">
        <a href="../index.php" class="btn btn-dark">
            ❮ Regresar
        </a>

        <a href="crear.php" class="btn btn-primary">
            + Nueva Noticia
        </a>
    </div>

</div>


    <div class="row g-4">

        <?php foreach ($noticias as $n): ?>

            <div class="col-md-4">
                <div class="card card-noticia h-100">

                    <!-- IMAGEN -->
                    <?php if (!empty($n['imagen'])): ?>
                        <img src="../<?= htmlspecialchars($n['imagen']) ?>"
                             class="card-img-top"
                             alt="Imagen noticia">
                    <?php else: ?>
                        <img src="../assets/img/no-image.jpg"
                             class="card-img-top"
                             alt="Sin imagen">
                    <?php endif; ?>

                    <div class="card-body">

                        <!-- TÍTULO -->
                        <h5 class="card-title">
                            <?= htmlspecialchars($n['titulo']) ?>
                        </h5>

                        <!-- CATEGORÍA -->
                        <span class="badge bg-secondary mb-2">
                            <?= htmlspecialchars($n['categorias_noticias']) ?>
                        </span>

                        <!-- FECHA Y HORA -->
                        <p class="text-muted mt-2 mb-3">
                            📅 <?= date('d-m-Y', strtotime($n['fecha_publicacion'])) ?>
                            &nbsp;⏰ <?= date('H:i', strtotime($n['hora_publicacion'])) ?>
                        </p>

                        <!-- ACCIONES -->
                        <div class="d-flex gap-2 mt-auto">

                            <a href="editar.php?id=<?= $n['id_noticia'] ?>"
                               class="btn btn-warning btn-sm w-50">
                                ✏️ Editar
                            </a>

                            <form action="eliminar.php" method="POST" class="w-50">
                                <input type="hidden" name="id" value="<?= $n['id_noticia'] ?>">
                                <button class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('¿Eliminar noticia?')">
                                    🗑️ Eliminar
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>
