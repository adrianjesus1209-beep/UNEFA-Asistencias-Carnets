<?php

namespace Config;

use PDO;
use PDOException;
use RuntimeException;

class DataBase
{
    /** Única instancia de la conexión */
    private static ?PDO $instance = null;

    /** Evita instanciación directa */
    private function __construct() {}

    /** Evita clonación */
    private function __clone() {}

    /** Evita deserialización */
    public function __wakeup()
    {
        throw new RuntimeException('No se puede deserializar la instancia de DataBase');
    }

    /**
     * Devuelve la conexión única (singleton).
     */
    public static function getConexion(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }
        return self::$instance;
    }

    /**
     * Reinicia la conexión (útil en tests).
     */
    public static function reset(): void
    {
        self::$instance = null;
    }

    /**
     * Crea la conexión PDO leyendo del .env.
     */
    private static function create(): PDO
    {
        $driver  = strtolower(Env::get('DB_CONNECTION', 'mysql'));
        $host    = Env::get('DB_HOST', '127.0.0.1');
        $port    = Env::get('DB_PORT');
        $bd      = Env::get('DB_DATABASE', '');
        $user    = Env::get('DB_USER', '');
        $pass    = Env::get('DB_PASS', '');
        $charset = Env::get('DB_CHARSET', 'utf8mb4');

        [$dsn, $opciones] = self::construirDsn(
            $driver, $host, $port, $bd, $charset
        );

        try {
            return new PDO($dsn, $user, $pass, $opciones);
        } catch (PDOException $e) {
            error_log('[DB] Error de conexión: ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar a la base de datos');
        }
    }

    /**
     * Construye el DSN y las opciones según el driver.
     *
     * @return array{0: string, 1: array}
     */
    private static function construirDsn(
        string $driver,
        string $host,
        ?string $port,
        string $bd,
        string $charset
    ): array {
        // Opciones comunes a todos los drivers
        $opcionesBase = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => false,
        ];

        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                $port ??= '3306';
                $dsn = "mysql:host=$host;port=$port;dbname=$bd;charset=$charset";
                break;

            case 'pgsql':
            case 'postgres':
                $port ??= '5432';
                $dsn = "pgsql:host=$host;port=$port;dbname=$bd";
                if ($charset !== '') {
                    $dsn .= ";options='--client_encoding=$charset'";
                }
                break;

            case 'sqlite':
                if ($bd === ':memory:') {
                    $dsn = 'sqlite::memory:';
                } else {
                    if (!is_file($bd)) {
                        throw new RuntimeException("Archivo SQLite no encontrado: $bd");
                    }
                    $dsn = "sqlite:$bd";
                }
                break;

            case 'sqlsrv':
                $port ??= '1433';
                $dsn = "sqlsrv:Server=$host,$port;Database=$bd";
                if ($charset !== '') {
                    $dsn .= ";CharacterSet=$charset";
                }
                break;

            default:
                throw new RuntimeException("Driver no soportado: $driver");
        }

        return [$dsn, $opcionesBase];
    }
}