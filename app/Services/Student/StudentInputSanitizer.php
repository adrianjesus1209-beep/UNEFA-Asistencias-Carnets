<?php

namespace App\Services\Student;

/**
 * Sanitizador de entradas y salidas a texto plano para el modulo Estudiante.
 *
 * Previene XSS, inyeccion de etiquetas HTML/scripts y caracteres de control,
 * y centraliza las expresiones regulares obligatorias del sistema.
 */
class StudentInputSanitizer
{
    /** Cedula: solo numeros (sin letras, puntos ni simbolos). */
    public const REGEX_CEDULA = '/^\d{6,20}$/';

    /** Nombres y apellidos: solo letras (incluyendo acentos y ñ) y espacios. */
    public const REGEX_SOLO_LETRAS = '/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/u';

    /**
     * Contrasena: 8 a 16 caracteres, minimo 1 mayuscula, 1 minuscula,
     * 1 numero y 1 caracter especial del conjunto #$/&+/
     */
    public const REGEX_PASSWORD = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#$\/&+]).{8,16}$/';

    /** Codigo de asignatura (ej. SIS-701). */
    public const REGEX_SUBJECT_CODE = '/^[A-Za-z0-9\-]{2,20}$/';

    /**
     * Convierte cualquier entrada o salida en texto plano seguro.
     */
    public static function plainText(mixed $value, ?int $maxLength = null): string
    {
        if ($value === null || is_array($value) || is_object($value)) {
            return '';
        }

        $text = (string) $value;

        // Eliminar bytes nulos y caracteres de control no imprimibles.
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $text) ?? '';

        // Decodificar entidades previas y remover cualquier bloque/etiqueta HTML o script.
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/<\s*(script|style)\b[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $text) ?? '';
        $text = strip_tags($text);

        // Eliminar caracteres de apertura/cierre de etiquetas residuales.
        $text = str_replace(['<', '>'], '', $text);

        // Normalizar espacios multiples y recortar extremos.
        $text = preg_replace('/\s+/u', ' ', $text) ?? '';
        $text = trim($text);

        if ($maxLength !== null && $maxLength > 0) {
            $text = mb_substr($text, 0, $maxLength, 'UTF-8');
        }

        return $text;
    }

    /**
     * Limpia un valor numerico dejando solo digitos (util para cedulas o IDs).
     */
    public static function onlyDigits(mixed $value): string
    {
        if ($value === null || is_array($value) || is_object($value)) {
            return '';
        }

        return preg_replace('/\D+/', '', (string) $value) ?? '';
    }

    /**
     * Formatea una cedula numerica con prefijo institucional para visualizacion segura.
     */
    public static function formatCedula(string $idType, string $idNumber): string
    {
        $type = strtoupper(self::plainText($idType, 2));
        if (! in_array($type, ['V', 'E', 'P'], true)) {
            $type = 'V';
        }

        $digits = self::onlyDigits($idNumber);
        if ($digits === '') {
            return $type.'-0';
        }

        return $type.'-'.number_format((float) $digits, 0, '', '.');
    }
}
