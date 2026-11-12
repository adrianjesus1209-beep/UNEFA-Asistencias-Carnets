<?php

namespace Core;

class Router
{
    private array $rutas = [];
    private array $rutasNombradas = [];
    private Container $container;

    public function __construct(?Container $container = null)
    {
        $this->container = $container ?? new Container();
    }

    public function get(string $url, array $accion, string $nombre = ''): void
    {
        $this->addRuta('GET', $url, $accion, $nombre);
    }

    public function post(string $url, array $accion, string $nombre = ''): void
    {
        $this->addRuta('POST', $url, $accion, $nombre);
    }

    private function addRuta(string $metodo, string $url, array $accion, string $nombre): void
    {
        $url = trim($url, '/');

        $this->rutas[$metodo][$url] = [
            'controlador' => $accion[0],
            'metodo'      => $accion[1],
        ];

        if ($nombre !== '') {
            $this->rutasNombradas[$nombre] = $url;
        }
    }

    public function getUrl(string $nombre): ?string
    {
        return $this->rutasNombradas[$nombre] ?? null;
    }

    public function dispatch(string $uri, string $metodoHttp): void
    {
        $uri = trim($uri, '/');
        $metodoHttp = strtoupper($metodoHttp);

        // 1. Match exacto
        if (isset($this->rutas[$metodoHttp][$uri])) {
            $this->ejecutar($this->rutas[$metodoHttp][$uri], []);
            return;
        }

        // 2. Match con parámetros {id}
        foreach ($this->rutas[$metodoHttp] ?? [] as $ruta => $accion) {
            $patron = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $ruta);
            $patron = '#^' . $patron . '$#';

            if (preg_match($patron, $uri, $coincidencias)) {
                array_shift($coincidencias);
                $this->ejecutar($accion, $coincidencias);
                return;
            }
        }

        // 3. 404
        http_response_code(404);
        $vista404 = BASE_PATH . '/frontend/views/404.php';
        if (is_file($vista404)) {
            require $vista404;
        } else {
            echo "404 — Ruta no encontrada: $uri";
        }
    }

    private function ejecutar(array $accion, array $params): void
    {
        $controlador = $accion['controlador'];
        $metodo      = $accion['metodo'];
        $clase       = "\\Controllers\\" . $controlador;

        if (!class_exists($clase)) {
            http_response_code(500);
            echo "Controlador no encontrado: $clase";
            return;
        }

        try {
            $objeto = $this->container->make($clase);
        } catch (\Throwable $e) {
            error_log('[Router] ' . $e->getMessage());
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'ok'    => false,
                'msg'   => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'class' => $clase,
            ]);
            return;
        }

        if (!method_exists($objeto, $metodo)) {
            http_response_code(500);
            echo "Método no encontrado: $metodo";
            return;
        }

        try {
            call_user_func_array([$objeto, $metodo], $params);
        } catch (\Throwable $e) {
            error_log('[Router] Excepción en ' . $metodo . '(): ' . $e->getMessage());
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