<?php

/*
|--------------------------------------------------------------------------
| Bootstrap de la vista previa Blade (UnefaWeb)
|--------------------------------------------------------------------------
|
| Monta el compilador real de Blade (illuminate/view) sin instalar el
| framework Laravel completo, y define los helpers route() y asset()
| que usan las vistas.
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
    function route(string $name, array $params = []): string
    {
        if ($name === 'dashboard') {
            $rol = $params['rol'] ?? 'estudiante';
            $seccion = $params['seccion'] ?? 'inicio';

            if ($seccion === 'inicio') {
                return '/dashboard/' . rawurlencode((string) $rol);
            }

            return '/dashboard/' . rawurlencode((string) $rol) . '/' . rawurlencode((string) $seccion);
        }

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

// Resuelve la vista y los datos iniciales para cada path (espejo de routes/web.php).
function unefa_resolver_path(string $path): ?array
{
    static $mapa = [
        '/landing' => ['vista' => 'landing.index', 'data' => []],
        '/login' => ['vista' => 'auth.login', 'data' => []],
        '/registro' => ['vista' => 'auth.registro', 'data' => []],
    ];

    if (isset($mapa[$path])) {
        return $mapa[$path];
    }

    $rolesPermitidos = ['estudiante', 'profesor', 'coordinador', 'director'];

    if ($path === '/dashboard') {
        $rol = (string) ($_GET['rol'] ?? 'estudiante');
        $seccion = (string) ($_GET['seccion'] ?? 'inicio');

        return [
            'vista' => 'dashboard.index',
            'data' => [
                'rol' => in_array($rol, $rolesPermitidos, true) ? $rol : 'estudiante',
                'seccion' => $seccion ?: 'inicio',
            ],
        ];
    }

    if (preg_match('#^/dashboard/(estudiante|profesor|coordinador|director)(?:/([a-z0-9-]+))?$#', $path, $coincidencias)) {
        return [
            'vista' => 'dashboard.index',
            'data' => [
                'rol' => (string) ($_GET['rol'] ?? $coincidencias[1]),
                'seccion' => (string) ($_GET['seccion'] ?? ($coincidencias[2] ?? 'inicio')),
            ],
        ];
    }

    return null;
}

function unefa_vista_por_path(string $path): ?string
{
    $resuelto = unefa_resolver_path($path);

    return $resuelto['vista'] ?? null;
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
