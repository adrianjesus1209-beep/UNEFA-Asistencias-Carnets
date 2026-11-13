<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// definir la ruta base y cargar el autoload de Composer //
define('BASE_PATH', dirname(__DIR__, 2));
require BASE_PATH . '/vendor/autoload.php';

use Core\Router;
use Core\Container;
use Config\Env;
use Config\DataBase;
use PDO;

// cargar variables de entorno desde el archivo .env //
Env::load(BASE_PATH . '/.env');

// configurar la conexion a la base de datos y el contenedor de dependencias //
$container = new Container();
$container->bind(PDO::class, fn() => DataBase::getConnection());

$router = new Router($container);
$GLOBALS['router'] = $router;

// cargar helpers y rutas //
require BASE_PATH . '/backend/core/helpers.php';
require BASE_PATH . '/backend/router/Router.php';

// iniciar sesion //
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// auto-logout por inactividad //
if (!empty($_SESSION['user_id'])) {
    $tiempoInactividad = 600;
    $ultimaActividad   = $_SESSION['last_activity'] ?? time();

    if (time() - $ultimaActividad > $tiempoInactividad) {
        session_unset();
        session_destroy();

        $esAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
               || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

        if ($esAjax) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'ok'       => false,
                'msg'      => 'Sesion expirada por inactividad',
                'redirect' => route('login'),
            ]);
        } else {
            header('Location: ' . route('login') . '?expirada=1');
        }
        exit;
    }

    $_SESSION['last_activity'] = time();
}

// generar token CSRF si no existe //
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time();
}

// limpiar la URI //
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// quitar el prefijo de la ruta base si existe //
$basePath = rtrim($_ENV['APP_BASE_PATH'] ?? '', '/');
if ($basePath !== '' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = trim($uri, '/');

// rutas limpias para trabajar con el index //
if (str_starts_with($uri, 'frontend/public')) {
    $uri = preg_replace('#^frontend/public(/index\.php)?#', '', $uri);
    $uri = trim($uri, '/');
}

if ($uri === 'index.php' || str_ends_with($uri, '/index.php')) {
    $uri = preg_replace('#/?index\.php$#', '', $uri);
    $uri = trim($uri, '/');
}


// despachar la ruta correspondiente segun la URI y el metodo HTTP //
$metodo = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$router->dispatch($uri, $metodo);