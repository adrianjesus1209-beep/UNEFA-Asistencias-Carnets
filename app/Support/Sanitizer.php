<?php

namespace App\Support;

class Sanitizer
{
    public static function clean(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return htmlspecialchars(
            strip_tags(trim($value)),
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }

    public static function cedula(?string $value): ?string
    {
        $v = preg_replace('/\D+/', '', (string) $value);

        return ($v !== '' && strlen($v) >= 6 && strlen($v) <= 9) ? $v : null;
    }

    public static function letters(?string $value): ?string
    {
        $v = preg_replace('/[^\pL\s]+/u', '', (string) $value);
        $v = preg_replace('/\s+/', ' ', trim($v));

        return $v !== '' ? $v : null;
    }
}