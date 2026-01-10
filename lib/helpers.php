<?php
function getBaseUrl(): string
{
    // Detectar protocolo
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $scheme = $https ? 'https' : 'http';

    // Host (ya incluye puerto si es distinto a 80/443)
    $host = $_SERVER['HTTP_HOST']; // ej: localhost, localhost:8080, midominio.cl

    // Ruta base del proyecto
    // SCRIPT_NAME = /carpeta/iniciar_pago.php
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); // -> /carpeta

    return $scheme . '://' . $host . $basePath;
}