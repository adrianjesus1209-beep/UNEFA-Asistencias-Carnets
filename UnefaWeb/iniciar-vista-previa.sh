#!/usr/bin/env bash
# Servidor de vista previa del portal UNEFA (herramienta local).
# Arranca en http://127.0.0.1:8099 y se detiene con Ctrl+C.
set -e
cd "$(dirname "$0")"

if [ ! -f tools/preview/vendor/autoload.php ]; then
    echo "Faltan dependencias de la vista previa. Ejecuta primero:"
    echo "    cd tools/preview && composer install"
    exit 1
fi

echo "Vista previa UNEFA en http://127.0.0.1:8099 (Ctrl+C para detener)"
exec php -S 127.0.0.1:8099 preview.php
