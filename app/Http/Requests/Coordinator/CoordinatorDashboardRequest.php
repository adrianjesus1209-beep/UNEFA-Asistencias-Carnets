<?php

namespace App\Http\Requests\Coordinator;

use App\Support\Sanitizer;
use Illuminate\Foundation\Http\FormRequest;

class CoordinatorDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $sanitized = [];

        if ($this->has('search')) {
            $sanitized['search'] = Sanitizer::clean((string) $this->input('search'));
        }

        if ($this->has('cedula')) {
            $sanitized['cedula'] = Sanitizer::cedula((string) $this->input('cedula'));
        }

        if ($this->has('nombres')) {
            $sanitized['nombres'] = Sanitizer::letters((string) $this->input('nombres'));
        }

        if ($this->has('apellidos')) {
            $sanitized['apellidos'] = Sanitizer::letters((string) $this->input('apellidos'));
        }

        if ($this->has('email')) {
            $sanitized['email'] = trim(strip_tags((string) $this->input('email')));
        }

        if (!empty($sanitized)) {
            $this->merge($sanitized);
        }
    }

    public function rules(): array
    {
        return [
            'career_id' => ['nullable', 'integer', 'min:1'],
            'period_id' => ['nullable', 'integer', 'min:1'],
            'search'    => ['nullable', 'string', 'max:100'],
            'cedula'    => ['nullable', 'regex:/^[0-9]+$/', 'max:15'],
            'nombres'   => ['nullable', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u', 'max:80'],
            'apellidos' => ['nullable', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u', 'max:80'],
            'email'     => ['nullable', 'email', 'max:150'],
            'password'  => [
                'nullable',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$\/&+\/])[A-Za-z\d#$\/&+\/]{8,16}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.regex'    => 'La cédula debe contener solo números, sin letras, puntos ni símbolos.',
            'nombres.regex'   => 'Los nombres deben contener solo letras, sin números ni símbolos.',
            'apellidos.regex' => 'Los apellidos deben contener solo letras, sin números ni símbolos.',
            'email.email'     => 'El correo electrónico debe tener un formato válido.',
            'password.regex'  => 'La contraseña debe tener entre 8 y 16 caracteres, con al menos 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial (#$/&+/).',
        ];
    }
}