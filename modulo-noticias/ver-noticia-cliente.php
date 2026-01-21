<?php
// modulo-noticias/ver-noticia-cliente.php

// IMPORTANTE: No definimos funciones active() aquí porque ya vienen del index.php

// 1. Incluimos la lógica que trae las noticias de la base de datos
// Usamos __DIR__ para encontrar la librería subiendo un nivel
$rutaLibreria = __DIR__ . '/../lib/listar-noticia.php';

if (file_exists($rutaLibreria)) {
    include_once $rutaLibreria;
} else {
    // Fallback por si la estructura es diferente
    include_once 'lib/listar-noticia.php';
}

// 2. Definir variable base para las rutas de imágenes si no existe
if (!isset($base)) { $base = './'; }
?>

<section class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary border-bottom pb-2">Noticias Recientes</h2>
        </div>
    </div>

    <div class="row g-4">
        
        <?php if (empty($listaNoticias)): ?>
            <div class="col-12">
                <div class="alert alert-info py-4 text-center">
                    <i class="bi bi-newspaper fs-1 d-block mb-3"></i>
                    <h5>No hay noticias publicadas</h5>
                    <p class="mb-0">Aún no se han publicado novedades en la comunidad.</p>
                </div>
            </div>
        <?php else: ?>

            <?php foreach ($listaNoticias as $noticia): ?>
                <?php 
                    /* --- ARREGLO REAL DE RUTA DE IMAGEN (assets/img/noticias) --- */

                    // 1) Lo que venga desde BD
                    $rutaDB = trim((string)($noticia['imagen'] ?? ''));

                    // 2) Normalizar: quitar "../" al inicio si existe
                    $rutaRel = preg_replace('#^(\.\./)+#', '', $rutaDB);

                    // 3) Si BD guarda solo el nombre (ej: "foto.jpg"), lo metemos en la carpeta correcta
                    if ($rutaRel !== '' && !str_contains($rutaRel, '/')) {
                        $rutaRel = 'assets/img/noticias/' . $rutaRel;
                    }

                    // 4) Si no viene con la carpeta, también la forzamos
                    if ($rutaRel !== '' && !str_contains($rutaRel, 'assets/img/noticias/')) {
                        $rutaRel = 'assets/img/noticias/' . basename($rutaRel);
                    }

                    // 5) Validación física (en disco). Desde modulo-noticias subimos a la raíz: ../
                    $rutaFisica = __DIR__ . '/../' . $rutaRel;

                    // 6) URL final para <img>
                    if ($rutaRel !== '' && file_exists($rutaFisica)) {
                        $imgSrc = $base . $rutaRel;
                    } else {
                        $imgSrc = "https://via.placeholder.com/400x250?text=Sin+Imagen";
                    }
                ?>

                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card shadow-sm border-0 w-100">
                        
                        <img src="<?= htmlspecialchars($imgSrc) ?>" 
                             class="card-img-top" 
                             alt="Imagen Noticia" 
                             style="height: 200px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                                    <?= htmlspecialchars($noticia['categoria'] ?? 'General') ?>
                                </span>
                                <span class="text-muted">
                                    <i class="bi bi-calendar3"></i> 
                                    <?= date("d/m/Y", strtotime($noticia['fecha_publicacion'])) ?>
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-dark">
                                <?= htmlspecialchars($noticia['titulo']) ?>
                            </h5>

                            <p class="card-text text-secondary flex-grow-1">
                                <?= htmlspecialchars(substr($noticia['bajada'], 0, 100)) ?>...
                            </p>
                            
                            <div class="mt-3">
                                <a href="<?= $base ?>modulo-noticias/noticia-detalle-cliente.php?id=<?= (int)$noticia['id_noticia'] ?>" 
                                   class="btn btn-outline-primary w-100">
                                   Leer completa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
        <?php endif; ?>

    </div>
</section>