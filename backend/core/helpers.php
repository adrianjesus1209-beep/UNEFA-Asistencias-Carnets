<?php

// funcion para generar URLs //
if (!function_exists('route')) {
    function route(string $name, array $params = []): string {
        global $router;

        $url = $router->getUrl($name);

        if ($url === null) {
            $url = $name;
        }

        // reemplazar {id}, {slug} //
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        // base URL desde el .env //
        $baseUrl = $_ENV['APP_URL'] ?? '';

        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }
}

// carga una vista desde /frontend/views/ //
if (!function_exists('view')) {
    function view(string $name, array $data = []): void {
        extract($data);
        require BASE_PATH . '/frontend/views/' . $name . '.php';
    }
}

// genera la URL de un asset [CSS, JS, imagen] //
if (!function_exists('asset')) {
    function asset(string $path): string {
        $baseUrl = $_ENV['APP_URL'] ?? '';
        return rtrim($baseUrl, '/') . '/frontend/public/' . ltrim($path, '/');
    }
}

// genera el HTML para un avatar circular con iniciales //
if (!function_exists('avatarHtml')) {
    function avatarHtml(string $size = 'w-9 h-9'): string
    {
        $name = $_SESSION['user_name'] ?? 'U';

        $html  = '<div class="' . $size . ' rounded-full bg-gradient-to-tr from-orbis-primary to-orbis-accent p-0.5 hover:scale-105 transition-transform">';
        $html .= '<div class="w-full h-full rounded-full bg-orbis-card flex items-center justify-center font-bold text-xs overflow-hidden">';

        $html .= strtoupper(substr($name, 0, 1));

        $html .= '</div></div>';

        return $html;
    }

    // genera el HTML para un campo oculto con el token CSRF //
    if (!function_exists('csrf_field')) {
        function csrf_field(): string
        {
            $token = $_SESSION['csrf_token'] ?? '';
            return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token) . '">';
        }
    }

    // obtiene el token CSRF actual //
    if (!function_exists('csrf_token')) {
        function csrf_token(): string
        {
            return $_SESSION['csrf_token'] ?? '';
        }
    }
}