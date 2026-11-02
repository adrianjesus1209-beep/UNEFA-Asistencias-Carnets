<?php
if (!function_exists('route')) {
    function route(string $nombre, array $params = []): string
    {
        global $router;

        $url = $router->getUrl($nombre);

        if ($url === null) {
            $url = $nombre;
        }

        foreach ($params as $clave => $valor) {
            $url = str_replace('{' . $clave . '}', $valor, $url);
        }

       
        $baseUrl = $_ENV['APP_URL'] ?? '';

        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }
}

/**
 * Carga una vista desde /frontend/views/.
 */
if (!function_exists('view')) {
    function view(string $nombre, array $datos = []): void
    {
        extract($datos);
        require BASE_PATH . '/frontend/views/' . $nombre . '.php';
    }
}

if (!function_exists('asset')) {
    function asset(string $ruta): string
    {
        $baseUrl = $_ENV['APP_URL'] ?? '';
        return rtrim($baseUrl, '/') . '/frontend/public/' . ltrim($ruta, '/');
    }
}

if (!function_exists('avatarHtml')) {
    function avatarHtml(string $size = 'w-9 h-9'): string
    {
        $name   = $_SESSION['user_name']   ?? 'U';
        $avatar = $_SESSION['user_avatar'] ?? null;

        $html  = '<div class="' . $size . ' rounded-full bg-gradient-to-tr from-orbis-primary to-orbis-accent p-0.5 hover:scale-105 transition-transform">';
        $html .= '<div class="w-full h-full rounded-full bg-orbis-card flex items-center justify-center font-bold text-xs overflow-hidden">';

        if (!empty($avatar)) {
            $html .= '<img src="' . asset($avatar) . '" alt="Avatar" class="w-full h-full object-cover">';
        } else {
            $html .= strtoupper(substr($name, 0, 1));
        }

        $html .= '</div></div>';

        return $html;
    }

    if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = $_SESSION['csrf_token'] ?? '';
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token) . '">';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }
}
}