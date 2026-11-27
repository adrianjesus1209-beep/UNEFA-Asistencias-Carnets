<?php

/*
|--------------------------------------------------------------------------
| Vista previa de las vistas Blade (sin entorno Laravel completo)
|--------------------------------------------------------------------------
|
| Router para el servidor nativo de PHP:
|
|     php -S 127.0.0.1:8099 preview.php
|
| - Los archivos de public/ (CSS, JS, imagenes) se sirven tal cual.
| - Las rutas de routes/web.php renderizan la vista Blade correspondiente
|   con el compilador real de illuminate/view.
| - /__preview/version devuelve la fecha de la ultima vista modificada;
|   el snippet inyectado en el HTML consulta ese valor y recarga la
|   pagina automaticamente al detectar cambios (auto-recarga).
|
*/

declare(strict_types=1);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$uri = rtrim($uri, '/') ?: '/';

// Archivos estaticos desde public/ (el docroot del servidor nativo es la
// raiz de UnefaWeb, por lo que se leen y sirven desde public/ a mano).
$archivoEstatico = __DIR__ . '/public' . $uri;
if ($uri !== '/' && is_file($archivoEstatico)) {
    $mimePorExtension = [
        'css' => 'text/css; charset=utf-8',
        'js' => 'text/javascript; charset=utf-8',
        'mjs' => 'text/javascript; charset=utf-8',
        'html' => 'text/html; charset=utf-8',
        'json' => 'application/json; charset=utf-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'pdf' => 'application/pdf',
        'txt' => 'text/plain; charset=utf-8',
        'xml' => 'application/xml; charset=utf-8',
    ];
    $extension = strtolower(pathinfo($archivoEstatico, PATHINFO_EXTENSION));
    $mime = $mimePorExtension[$extension] ?? (mime_content_type($archivoEstatico) ?: 'application/octet-stream');
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . (string) filesize($archivoEstatico));
    header('Cache-Control: no-cache');
    readfile($archivoEstatico);
    exit;
}

require __DIR__ . '/tools/preview/bootstrap.php';

// Endpoint de auto-recarga: version de contenido de las vistas.
if ($uri === '/__preview/version') {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode(['version' => unefa_vistas_version()]);
    exit;
}

// Raiz: redirige a la landing (igual que Route::redirect('/', '/landing')).
if ($uri === '/') {
    header('Location: /landing', true, 302);
    exit;
}

$resuelto = unefa_resolver_path($uri);

if ($resuelto === null) {
    http_response_code(404);
    header('Content-Type: text/html; charset=utf-8');
    echo '<pre>404 - Ruta fuera del mapa de la vista previa: ' . htmlspecialchars($uri) . '</pre>';
    exit;
}

$vista = $resuelto['vista'];

try {
    $html = unefa_render($vista, $resuelto['data']);
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<pre>Error al renderizar ' . htmlspecialchars($vista) . ":\n\n"
        . htmlspecialchars($e->getMessage()) . "\n\n"
        . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    exit;
}

// Auto-recarga: consulta la version de las vistas y recarga al cambiar.
$autoRecarga = <<<'HTML'
<script>
(function () {
    var version = null;
    setInterval(function () {
        fetch('/__preview/version?_=' + Date.now(), { cache: 'no-store' })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (version === null) { version = d.version; return; }
                if (d.version !== version) { location.reload(); }
            })
            .catch(function () {});
    }, 1000);
})();
</script>
HTML;

$html = str_ireplace('</body>', $autoRecarga . "\n</body>", $html);

header('Content-Type: text/html; charset=utf-8');
echo $html;
