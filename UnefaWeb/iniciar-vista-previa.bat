@echo off
rem Servidor de vista previa del portal UNEFA (herramienta local).
rem Arranca en http://127.0.0.1:8099 y se detiene con Ctrl+C.
cd /d "%~dp0"
if not exist "tools\preview\vendor\autoload.php" (
    echo Faltan dependencias de la vista previa. Ejecuta primero:
    echo     cd tools\preview ^&^& composer install
    pause
    exit /b 1
)
echo Vista previa UNEFA en http://127.0.0.1:8099 (Ctrl+C para detener)
php -S 127.0.0.1:8099 preview.php
