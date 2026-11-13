<?php

namespace Config;

class Env {

    // carga las variables de entorno desde un archivo .env //
    public static function load(string $path): void {
        if (!is_readable($path)) {
            throw new \RuntimeException("No se puede leer el archivo .env: $path");
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);

            // ignorar comentarios y lineas vacias //
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);

            // Quitar comillas si las hay //
            if (preg_match('/^"(.*)"$/', $value, $m)) {
                $value = $m[1];
            } elseif (preg_match("/^'(.*)'$/", $value, $m)) {
                $value = $m[1];
            }

            // no sobreescribir variables ya definidas en el sistema //
            if (getenv($key) === false) {
                putenv("$key=$value");
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
            }
        }
    }

    // obtiene el valor de una variable de entorno, con un valor por defecto //
    public static function get(string $key, mixed $default = null): mixed {
        $value = $_ENV[$key] ?? getenv($key);
        return ($value === false || $value === null) ? $default : $value;
    }

    // obtiene el valor de una variable de entorno como entero, con un valor por defecto //
    public static function getInt(string $key, int $default = 0): int {
        return (int) self::get($key, $default);
    }
}