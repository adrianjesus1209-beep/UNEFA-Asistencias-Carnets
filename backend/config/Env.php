<?php
// carga el .env // 
namespace Config;

class Env{
    
    public static function cargar(string $ruta): void{
        if (!is_readable($ruta)) {
            throw new \RuntimeException("No se puede leer el archivo .env: $ruta");
        }

        foreach (file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
            $linea = trim($linea);

            // Ignorar comentarios y líneas vacías
            if ($linea === '' || str_starts_with($linea, '#')) {
                continue;
            }

            if (!str_contains($linea, '=')) {
                continue;
            }

            [$clave, $valor] = explode('=', $linea, 2);
            $clave = trim($clave);
            $valor = trim($valor);

            // Quitar comillas si las hay
            if (preg_match('/^"(.*)"$/', $valor, $m) || preg_match("/^'(.*)'$/", $valor, $m)) {
                $valor = $m[1];
            }

            // No sobreescribir variables ya definidas en el sistema
            if (getenv($clave) === false) {
                putenv("$clave=$valor");
                $_ENV[$clave]    = $valor;
                $_SERVER[$clave] = $valor;
            }
        }
    }

    public static function get(string $clave, mixed $default = null): mixed
    {
        $valor = $_ENV[$clave] ?? getenv($clave);
        return ($valor === false || $valor === null) ? $default : $valor;
    }

    public static function getInt(string $clave, int $default = 0): int
    {
        return (int) self::get($clave, $default);
    }
}