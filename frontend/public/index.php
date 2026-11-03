<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

define('BASE_PATH', dirname(__DIR__, 2));
require BASE_PATH . '/vendor/autoload.php';

use Core\Router;
use Core\Container;
use Config\Env;
use PDO;

Env::cargar(BASE_PATH . '/.env');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!empty($_SESSION['user_id'])) {
    $tiempoInactividad = 600; 
    $ultimaActividad   = $_SESSION['last_activity'] ?? time();

    if (time() - $ultimaActividad > $tiempoInactividad) {
        // Sesión expirada
        session_unset();
        session_destroy();

        
        $esAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
               || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

        if ($esAjax) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'ok'       => false,
                'msg'      => 'Sesión expirada por inactividad',
                'redirect' => route('login'),
            ]);
        } else {
            header('Location: ' . route('login') . '?expirada=1');
        }
        exit;
    }

    
    $_SESSION['last_activity'] = time();
}



if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time();
}

$container = new Container();
$container->bind(PDO::class, fn() => \Config\DataBase::getConexion());
$router = new Router($container);
$GLOBALS['router'] = $router;

require BASE_PATH . '/bankend/core/helpers.php';
require BASE_PATH . '/bankend/router/Router.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';


$basePath = $_ENV['APP_BASE_PATH'] ?? '';
if ($basePath !== '' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = trim($uri, '/');

$metodo = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$router->dispatch($uri, $metodo);