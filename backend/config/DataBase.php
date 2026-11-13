<?php

namespace Config;

use PDO;
use PDOException;
use RuntimeException;

class DataBase {
    // instancia unica de la conexion //
    private static ?PDO $instance = null;

    // evita instanciacion directa //
    private function __construct() {}

    // evita clonacion //
    private function __clone() {}

    // Evita deserialización
    public function __wakeup()
    {
        throw new RuntimeException('No se puede deserializar la instancia de DataBase');
    }

    // devuelve la conexion unica //
    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = self::create();
        }
        return self::$instance;
    }

    // reinicia la conexion //
    public static function reset(): void {
        self::$instance = null;
    }

    // crea la conexion PDO leyendo del .env //
    private static function create(): PDO {
        $driver   = strtolower(Env::get('DB_CONNECTION', 'mysql'));
        $host     = Env::get('DB_HOST', '127.0.0.1');
        $port     = Env::get('DB_PORT');
        $database = Env::get('DB_DATABASE', '');
        $user     = Env::get('DB_USER', '');
        $pass     = Env::get('DB_PASS', '');
        $charset  = Env::get('DB_CHARSET', 'utf8mb4');

        [$dsn, $options] = self::buildDsn(
            $driver, $host, $port, $database, $charset
        );

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            error_log('[DB] Error de conexión: ' . $e->getMessage());
            throw new RuntimeException('No se pudo conectar a la base de datos');
        }
    }

    // construye el DSN y las opciones segun el driver //
    private static function buildDsn(
        string $driver,
        string $host,
        ?string $port,
        string $database,
        string $charset
    ): array {
        $baseOptions = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => false,
        ];

        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                $port ??= '3306';
                $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=$charset";
                break;

            case 'pgsql':
            case 'postgres':
                $port ??= '5432';
                $dsn = "pgsql:host=$host;port=$port;dbname=$database";
                if ($charset !== '') {
                    $dsn .= ";options='--client_encoding=$charset'";
                }
                break;

            case 'sqlite':
                if ($database === ':memory:') {
                    $dsn = 'sqlite::memory:';
                } else {
                    if (!is_file($database)) {
                        throw new RuntimeException("Archivo SQLite no encontrado: $database");
                    }
                    $dsn = "sqlite:$database";
                }
                break;

            case 'sqlsrv':
                $port ??= '1433';
                $dsn = "sqlsrv:Server=$host,$port;Database=$database";
                if ($charset !== '') {
                    $dsn .= ";CharacterSet=$charset";
                }
                break;

            default:
                throw new RuntimeException("Driver no soportado: $driver");
        }

        return [$dsn, $baseOptions];
    }
}