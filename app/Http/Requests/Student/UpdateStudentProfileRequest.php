<?php

namespace App\Http\Requests\Student;

use App\Services\Student\StudentDashboardService;
use App\Services\Student\StudentInputSanitizer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest dedicado para validar campos de identidad/cuenta del estudiante
 * cumpliendo estrictamente la Regla #5 del departamento de Backend:
 * - Cedula: solo numeros
 * - Nombres y apellidos: solo letras
 * - Contrasena: 8-16 caracteres, 1 mayuscula, 1 minuscula, 1 numero y 1 especial de #$/&+/
 * - Correo: formato valido
 */
class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $service = app(StudentDashboardService::class);
        $studentId = $service->resolveAuthenticatedStudentId($this);

        if ($studentId === null) {
            return false;
        }

        return $service->hasActiveStudentRole($studentId);
    }

    protected function prepareForValidation(): void
    {
        $merged = [];

        foreach (['first_name', 'middle_name', 'last_name', 'second_last_name', 'address'] as $field) {
            if ($this->has($field) && $this->input($field) !== null) {
                $merged[$field] = StudentInputSanitizer::plainText($this->input($field), 255);
            }
        }

        if ($this->has('email') && $this->input('email') !== null) {
            $merged['email'] = strtolower(StudentInputSanitizer::plainText($this->input('email'), 100));
        }

        if ($this->has('phone') && $this->input('phone') !== null) {
            $merged['phone'] = StudentInputSanitizer::onlyDigits($this->input('phone'));
        }

        if ($this->has('id_number') && $this->input('id_number') !== null) {
            $merged['id_number'] = StudentInputSanitizer::plainText($this->input('id_number'), 20);
        }

        if ($merged !== []) {
            $this->merge($merged);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id_number' => ['sometimes', 'required', 'string', 'regex:'.StudentInputSanitizer::REGEX_CEDULA],
            'first_name' => ['sometimes', 'required', 'string', 'max:50', 'regex:'.StudentInputSanitizer::REGEX_SOLO_LETRAS],
            'middle_name' => ['nullable', 'string', 'max:50', 'regex:'.StudentInputSanitizer::REGEX_SOLO_LETRAS],
            'last_name' => ['sometimes', 'required', 'string', 'max:50', 'regex:'.StudentInputSanitizer::REGEX_SOLO_LETRAS],
            'second_last_name' => ['nullable', 'string', 'max:50', 'regex:'.StudentInputSanitizer::REGEX_SOLO_LETRAS],
            'email' => ['sometimes', 'required', 'string', 'email:rfc', 'max:100'],
            'phone' => ['nullable', 'string', 'regex:/^\d{7,20}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'max:16', 'regex:'.StudentInputSanitizer::REGEX_PASSWORD],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_number.regex' => 'La cedula debe contener unicamente numeros (sin letras, puntos ni simbolos).',
            'first_name.regex' => 'El primer nombre debe contener solo letras.',
            'middle_name.regex' => 'El segundo nombre debe contener solo letras.',
            'last_name.regex' => 'El primer apellido debe contener solo letras.',
            'second_last_name.regex' => 'El segundo apellido debe contener solo letras.',
            'email.email' => 'Debe ingresar un formato de correo electronico valido.',
            'password.min' => 'La contrasena debe tener minimo 8 caracteres.',
            'password.max' => 'La contrasena debe tener maximo 16 caracteres.',
            'password.regex' => 'La contrasena debe incluir al menos 1 mayuscula, 1 minuscula, 1 numero y 1 caracter especial de #$/&+/.',
        ];
    }
}
