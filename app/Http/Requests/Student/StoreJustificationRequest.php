<?php

namespace App\Http\Requests\Student;

use App\Services\Student\StudentDashboardService;
use App\Services\Student\StudentInputSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Validacion y sanitizacion para la consignacion de justificativos de inasistencia
 * por parte del estudiante autenticado (tabla document_registration).
 */
class StoreJustificationRequest extends FormRequest
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

        if ($this->has('file_type')) {
            $merged['file_type'] = StudentInputSanitizer::plainText($this->input('file_type'), 20);
        }

        if ($this->has('observations')) {
            $merged['observations'] = StudentInputSanitizer::plainText($this->input('observations'), 500);
        }

        if ($this->filled('session_id')) {
            $merged['session_id'] = StudentInputSanitizer::onlyDigits($this->input('session_id'));
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
            'session_id' => ['nullable', 'integer', 'min:1'],
            'file_type' => ['required', 'string', 'in:PDF,Image,Word,Excel'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:5120'],
            'observations' => ['required', 'string', 'min:10', 'max:500'],
        ];
    }

    /**
     * Verifica aislamiento de datos: si el estudiante indica una sesion de clase,
     * dicha sesion debe corresponder a una seccion en la que este inscrito.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $sessionId = $this->input('session_id');
            if ($sessionId === null || $sessionId === '') {
                return;
            }

            $service = app(StudentDashboardService::class);
            $studentId = $service->resolveAuthenticatedStudentId($this);

            if ($studentId === null || ! $service->studentOwnsSession($studentId, (int) $sessionId)) {
                $validator->errors()->add(
                    'session_id',
                    'La sesion seleccionada no pertenece a tus asignaturas inscritas.'
                );
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file_type.required' => 'Debe seleccionar el tipo de documento.',
            'file_type.in' => 'El tipo de archivo debe ser PDF, Image, Word o Excel.',
            'document.required' => 'Debe adjuntar el archivo del justificativo.',
            'document.mimes' => 'Formato de archivo no permitido. Use PDF, JPG, PNG, DOC, DOCX, XLS o XLSX.',
            'document.max' => 'El archivo no puede superar los 5 MB.',
            'observations.required' => 'Debe escribir el motivo o descripcion del justificativo.',
            'observations.min' => 'La descripcion debe tener al menos 10 caracteres en texto plano.',
            'observations.max' => 'La descripcion no puede superar los 500 caracteres.',
        ];
    }
}
