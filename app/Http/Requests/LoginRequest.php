<?php

namespace App\Http\Requests;

use App\Support\AuthMessages;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $rawLogin = $this->input('login')
            ?? $this->input('email')
            ?? $this->input('username');

        if (($rawLogin === null || trim((string) $rawLogin) === '') && $this->filled('cedula')) {
            $docType = strtoupper(trim((string) $this->input('nacionalidad', '')));
            $cedula = preg_replace('/\D+/', '', (string) $this->input('cedula'));
            $rawLogin = ($docType === 'V' || $docType === 'E') && $cedula !== ''
                ? $docType . $cedula
                : $cedula;
        }

        $this->merge([
            'login'    => is_string($rawLogin) ? trim($rawLogin) : '',
            'password' => is_string($this->input('password')) ? $this->input('password') : '',
        ]);
    }

    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'min:3',
                'max:120',
                'regex:/^[a-zA-Z0-9._@\-]+$/',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:128',
            ],
            'remember' => [
                'sometimes',
                'boolean',
            ],
            'device_name' => [
                'sometimes',
                'nullable',
                'string',
                'max:80',
            ],
        ];
    }

    public function messages(): array
    {
        return AuthMessages::validation();
    }
}