<?php

namespace App\Support;

final class AuthMessages
{
    public static function validation(): array
    {
        return [
            'login.required'    => 'Debe ingresar su cédula, usuario o correo institucional.',
            'login.min'         => 'El identificador ingresado no es válido.',
            'login.max'         => 'El identificador excede la longitud permitida.',
            'login.regex'       => 'El identificador contiene caracteres no permitidos.',
            'password.required' => 'Debe ingresar su contraseña.',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max'      => 'La contraseña excede la longitud permitida.',
            'device_name.max'   => 'El nombre del dispositivo excede el límite permitido.',
        ];
    }

    public static function tooManyAttempts(int $minutes): string
    {
        return "Demasiados intentos fallidos. Intente nuevamente en {$minutes} minuto(s).";
    }

    public static function invalidCredentials(): string
    {
        return 'Credenciales inválidas o cuenta pendiente de aprobación.';
    }

    public static function noActiveRole(): string
    {
        return 'Su cuenta no tiene un rol activo asignado en el sistema.';
    }

    public static function accountInactive(): string
    {
        return 'Su cuenta no se encuentra activa o aprobada.';
    }

    public static function unauthorizedModule(): string
    {
        return 'No tiene permisos para acceder a este módulo.';
    }

    public static function unauthenticated(): string
    {
        return 'Debe iniciar sesión para acceder a este recurso.';
    }

    public static function loginSuccess(): string
    {
        return 'Autenticación exitosa.';
    }

    public static function logoutSuccess(): string
    {
        return 'Sesión cerrada correctamente.';
    }
}