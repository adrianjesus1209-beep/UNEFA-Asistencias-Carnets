<?php

namespace App\Http\Requests\Director;

use App\Services\Director\DirectorDashboardService;
use App\Support\Sanitizer;
use Illuminate\Foundation\Http\FormRequest;

class AssignCoordinatorRequest extends FormRequest
{
    public const REGEX_CEDULA = '/^[0-9]+$/';
    public const REGEX_SOLO_LETRAS = '/^[\p{L}\s]+$/u';
    public const REGEX_CLAVE = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$\/&+\/])[A-Za-z\d#$\/&+\/]{8,16}$/';

    public function authorize(): bool
    {
        $service = app(DirectorDashboardService::class);
        $userId = $service->resolveAuthenticatedUserId($this);

        if ($userId === null) {
            return false;
        }

        return $service->hasAuthorizedDirectorRole($userId);
    }

    protected function prepareForValidation(): void
    {
        $careerId = $this->input('career_id');
        $coordinatorId = $this->input('coordinator_id');
        $cedula = $this->input('cedula');
        $firstName = $this->input('first_name');
        $lastName = $this->input('last_name');
        $email = $this->input('email');

        $this->merge([
            'career_id'      => ($careerId !== null && $careerId !== '') ? preg_replace('/\D+/', '', (string) $careerId) : null,
            'coordinator_id' => ($coordinatorId !== null && $coordinatorId !== '') ? preg_replace('/\D+/', '', (string) $coordinatorId) : null,
            'cedula'         => ($cedula !== null && $cedula !== '') ? preg_replace('/\D+/', '', (string) $cedula) : null,
            'first_name'     => ($firstName !== null && $firstName !== '') ? Sanitizer::clean((string) $firstName) : null,
            'last_name'      => ($lastName !== null && $lastName !== '') ? Sanitizer::clean((string) $lastName) : null,
            'email'          => ($email !== null && $email !== '') ? strtolower((string) Sanitizer::clean((string) $email)) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'career_id'      => ['required', 'integer', 'min:1'],
            'coordinator_id' => ['required', 'integer', 'min:1'],
            'cedula'         => ['nullable', 'string', 'regex:' . self::REGEX_CEDULA],
            'first_name'     => ['nullable', 'string', 'max:50', 'regex:' . self::REGEX_SOLO_LETRAS],
            'last_name'      => ['nullable', 'string', 'max:50', 'regex:' . self::REGEX_SOLO_LETRAS],
            'email'          => ['nullable', 'string', 'max:100', 'email:rfc'],
            'password'       => ['nullable', 'string', 'min:8', 'max:16', 'regex:' . self::REGEX_CLAVE],
        ];
    }

    public function messages(): array
    {
        return [
            'career_id.required'      => 'Debe seleccionar una carrera válida.',
            'career_id.integer'       => 'La carrera seleccionada no es válida.',
            'coordinator_id.required' => 'Debe seleccionar un coordinador válido.',
            'coordinator_id.integer'  => 'El coordinador seleccionado no es válido.',
            'cedula.regex'            => 'La cédula solo debe contener números.',
            'first_name.regex'        => 'Los nombres solo deben contener letras.',
            'last_name.regex'         => 'Los apellidos solo deben contener letras.',
            'email.email'             => 'Debe ingresar un correo electrónico válido.',
            'password.min'            => 'La contraseña debe tener entre 8 y 16 caracteres.',
            'password.max'            => 'La contraseña debe tener entre 8 y 16 caracteres.',
            'password.regex'          => 'La contraseña debe incluir al menos 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial de #$/&+/.',
        ];
    }
}