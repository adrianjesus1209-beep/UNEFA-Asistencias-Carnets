<?php

/*
|--------------------------------------------------------------------------
| Bootstrap de la vista previa Blade (UnefaWeb)
|--------------------------------------------------------------------------
|
| Monta el compilador real de Blade (illuminate/view) sin instalar el
| framework Laravel completo, y define los helpers route() y asset()
| que usan las vistas. El backend Laravel reutilizara estas mismas
| vistas tal cual; aqui solo se replican los helpers minimos.
|
*/

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

// Raiz del portal (UnefaWeb).
$unefaBase = dirname(__DIR__, 2);

if (!defined('UNEFA_BASE_PATH')) {
    define('UNEFA_BASE_PATH', $unefaBase);
}

// Mapa de nombres de ruta a paths (espejo de routes/web.php).
if (!function_exists('route')) {
    function route(string $name): string
    {
        $rutas = [
            'landing' => '/landing',
            'login' => '/login',
            'registro' => '/registro',
            'dashboard.estudiante' => '/dashboard/estudiante',
            'dashboard.profesor' => '/dashboard/profesor',
            'dashboard.coordinador' => '/dashboard/coordinador',
            'dashboard.director' => '/dashboard/director',
        ];

        if (!isset($rutas[$name])) {
            throw new InvalidArgumentException("Ruta desconocida para la vista previa: {$name}");
        }

        return $rutas[$name];
    }
}

// Los assets se sirven desde public/ en la raiz del servidor.
if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return '/' . ltrim($path, '/');
    }
}

// Vista a nombre de vista para cada path (espejo de routes/web.php).
function unefa_vista_por_path(string $path): ?string
{
    static $mapa = [
        '/landing' => 'landing.index',
        '/login' => 'auth.login',
        '/registro' => 'auth.registro',
        '/dashboard/estudiante' => 'dashboard.student',
        '/dashboard/profesor' => 'dashboard.teacher',
        '/dashboard/coordinador' => 'dashboard.coordinator',
        '/dashboard/director' => 'dashboard.director',
    ];

    return $mapa[$path] ?? null;
}

// Crea la factory de vistas (compilador Blade real con cache en disco).
function unefa_view_factory(): Factory
{
    static $factory = null;

    if ($factory !== null) {
        return $factory;
    }

    $base = UNEFA_BASE_PATH;
    $cachePath = $base . '/tools/preview/cache';

    if (!is_dir($cachePath)) {
        mkdir($cachePath, 0777, true);
    }

    $files = new Filesystem;
    $compiler = new BladeCompiler($files, $cachePath);

    $resolver = new EngineResolver;
    $resolver->register('blade', fn () => new CompilerEngine($compiler, $files));

    $finder = new FileViewFinder($files, [$base . '/resources/views']);
    $events = new Dispatcher;

    $factory = new Factory($resolver, $finder, $events);

    return $factory;
}

// Renderiza una vista Blade y devuelve el HTML.
function unefa_render(string $vista, array $data = []): string
{
    return unefa_view_factory()->make($vista, $data)->render();
}

// Version de contenido: maxima fecha de modificacion de las vistas.
// El auto-recarga del navegador compara este valor para refrescar.
function unefa_vistas_version(): int
{
    $max = 0;
    $directorio = UNEFA_BASE_PATH . '/resources/views';

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directorio, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $archivo) {
        if ($archivo->isFile() && str_ends_with($archivo->getFilename(), '.blade.php')) {
            $max = max($max, $archivo->getMTime());
        }
    }

    return $max;
}
