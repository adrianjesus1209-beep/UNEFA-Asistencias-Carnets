<?php

namespace Core;

class Router {
    private array $routes = [];
    private array $namedRoutes = [];
    private Container $container;

    public function __construct(?Container $container = null) {
        $this->container = $container ?? new Container();
    }

    // agrega una ruta GET //
    public function get(string $url, array $action, string $name = ''): void {
        $this->addRoute('GET', $url, $action, $name);
    }

    // agrega una ruta POST //
    public function post(string $url, array $action, string $name = ''): void {
        $this->addRoute('POST', $url, $action, $name);
    }

    // agrega una ruta con el metodo HTTP especificado //
    private function addRoute(string $method, string $url, array $action, string $name): void {
        $url = trim($url, '/');

        $this->routes[$method][$url] = [
            'controller' => $action[0],
            'method'     => $action[1],
        ];

        if ($name !== '') {
            $this->namedRoutes[$name] = $url;
        }
    }

    // obtiene la URL de una ruta nombrada, o null si no existe //
    public function getUrl(string $name): ?string {
        return $this->namedRoutes[$name] ?? null;
    }

    // despacha la ruta correspondiente segun la URI y el metodo HTTP //
    public function dispatch(string $uri, string $httpMethod): void {
        $uri = trim($uri, '/');
        $httpMethod = strtoupper($httpMethod);

        // match exacto //
        if (isset($this->routes[$httpMethod][$uri])) {
            $this->execute($this->routes[$httpMethod][$uri], []);
            return;
        }

        // match con parametros {id} //
        foreach ($this->routes[$httpMethod] ?? [] as $route => $action) {
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->execute($action, $matches);
                return;
            }
        }

        // 404 //
        http_response_code(404);
        $view404 = BASE_PATH . '/frontend/views/404.php';
        if (is_file($view404)) {
            require $view404;
        } else {
            echo "404 — Ruta no encontrada: $uri";
        }
    }

    // ejecuta el controlador y metodo correspondiente a la ruta //
    private function execute(array $action, array $params): void {
        $controller = $action['controller'];
        $method     = $action['method'];
        $class      = "\\Controllers\\" . $controller;

        // verificar si la clase existe //
        if (!class_exists($class)) {
            http_response_code(500);
            echo "Controlador no encontrado: $class";
            return;
        }

        // instanciar el controlador usando el contenedor de dependencias //
        try {
            $instance = $this->container->make($class);
        } catch (\Throwable $e) {
            error_log('[Router] ' . $e->getMessage());
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'ok'    => false,
                'msg'   => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'class' => $class,
            ]);
            return;
        }

        // verificar si el metodo existe //
        if (!method_exists($instance, $method)) {
            http_response_code(500);
            echo "Método no encontrado: $method";
            return;
        }

        // ejecutar el metodo con los parametros //
        try {
            call_user_func_array([$instance, $method], $params);
        } catch (\Throwable $e) {
            error_log('[Router] Excepción en ' . $method . '(): ' . $e->getMessage());
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'ok'   => false,
                'msg'  => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}