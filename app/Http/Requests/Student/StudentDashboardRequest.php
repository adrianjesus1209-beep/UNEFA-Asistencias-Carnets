<?php

namespace App\Http\Requests\Student;

use App\Services\Student\StudentDashboardService;
use App\Services\Student\StudentInputSanitizer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validacion y autorizacion para la consulta del panel del estudiante.
 */
class StudentDashboardRequest extends FormRequest
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
        $sanitized = [];

        if ($this->has('period_id') && $this->input('period_id') !== null && $this->input('period_id') !== '') {
            $sanitized['period_id'] = StudentInputSanitizer::onlyDigits($this->input('period_id'));
        }

        if ($this->has('subject_code') && $this->input('subject_code') !== null && $this->input('subject_code') !== '') {
            $sanitized['subject_code'] = strtoupper(
                StudentInputSanitizer::plainText($this->input('subject_code'), 20)
            );
        }

        if ($this->has('status') && $this->input('status') !== null && $this->input('status') !== '') {
            $sanitized['status'] = StudentInputSanitizer::plainText($this->input('status'), 20);
        }

        if ($sanitized !== []) {
            $this->merge($sanitized);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'period_id' => ['nullable', 'integer', 'min:1'],
            'subject_code' => ['nullable', 'string', 'max:20', 'regex:'.StudentInputSanitizer::REGEX_SUBJECT_CODE],
            'status' => ['nullable', 'string', 'in:Enrolled,Approved,Failed,Pending'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'period_id.integer' => 'El periodo academico seleccionado no es valido.',
            'subject_code.regex' => 'El codigo de asignatura contiene caracteres no permitidos.',
            'status.in' => 'El estado de inscripcion indicado no es valido.',
        ];
    }
}
