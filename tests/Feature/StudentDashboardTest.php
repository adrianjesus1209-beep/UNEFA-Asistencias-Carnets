<?php

namespace Tests\Feature;

use App\Http\Requests\Student\UpdateStudentProfileRequest;
use App\Services\Student\StudentInputSanitizer;
use Database\Seeders\UnefaInitialDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (empty(config('app.key'))) {
            config(['app.key' => 'base64:'.base64_encode(str_repeat('a', 32))]);
        }

        $this->seed(UnefaInitialDataSeeder::class);

        // Rutas stub temporales solo en entorno de pruebas para los enlaces de layouts/partials
        // cuya implementacion pertenece a otros integrantes del equipo.
        $stubRoutes = [
            'landing' => '/_test-landing',
            'login' => '/_test-login',
            'dashboard.profesor' => '/_test-profesor',
            'dashboard.coordinador' => '/_test-coordinador',
            'dashboard.director' => '/_test-director',
        ];

        foreach ($stubRoutes as $name => $uri) {
            if (! Route::has($name)) {
                Route::get($uri, fn () => 'ok')->name($name);
            }
        }

        Route::getRoutes()->refreshNameLookups();
    }

    public function test_deniega_acceso_a_usuarios_no_autenticados(): void
    {
        $response = $this->get(route('dashboard.estudiante'));

        $response->assertForbidden();
    }

    public function test_deniega_acceso_a_usuario_sin_rol_student(): void
    {
        $teacherId = $this->createUserWithRole('Teacher', '19111222', 'Elena', 'Rivas', 'elena@unefa.edu.ve');

        $response = $this->withSession(['user_id' => $teacherId])
            ->get(route('dashboard.estudiante'));

        $response->assertForbidden();
    }

    public function test_muestra_datos_reales_y_aislados_del_estudiante_autenticado(): void
    {
        $teacherId = $this->createUserWithRole('Teacher', '18222333', 'Elena', 'Rivas', 'docente@unefa.edu.ve');
        $studentA = $this->createUserWithRole('Student', '28123456', 'Carlos', 'Mendoza', 'carlos@unefa.edu.ve', 'UNEFA-2022-04921');
        $studentB = $this->createUserWithRole('Student', '29999888', 'Otro', 'Alumno', 'otro@unefa.edu.ve', 'UNEFA-2022-99999');

        $subjectA = DB::table('subject')->insertGetId([
            'career_id' => 1,
            'subject_code' => 'SIS-701',
            'subject_name' => 'Sistemas Distribuidos',
            'semester' => 7,
            'credit_units' => 4,
            'display_order' => 1,
        ]);

        $subjectB = DB::table('subject')->insertGetId([
            'career_id' => 1,
            'subject_code' => 'SEC-999',
            'subject_name' => 'Materia Privada Tercero',
            'semester' => 7,
            'credit_units' => 3,
            'display_order' => 2,
        ]);

        $sectionA = DB::table('section')->insertGetId([
            'subject_id' => $subjectA,
            'teacher_id' => $teacherId,
            'period_id' => 1,
            'section_name' => '07S-2610-D1',
            'classroom' => 'Lab Telematica 2',
            'status' => 'Active',
        ]);

        $sectionB = DB::table('section')->insertGetId([
            'subject_id' => $subjectB,
            'teacher_id' => $teacherId,
            'period_id' => 1,
            'section_name' => '07S-2610-N1',
            'classroom' => 'Aula Privada',
            'status' => 'Active',
        ]);

        DB::table('section_enrollment')->insert([
            [
                'student_id' => $studentA,
                'section_id' => $sectionA,
                'period_id' => 1,
                'status' => 'Enrolled',
                'final_grade' => 18,
            ],
            [
                'student_id' => $studentB,
                'section_id' => $sectionB,
                'period_id' => 1,
                'status' => 'Enrolled',
                'final_grade' => 12,
            ],
        ]);

        $session1 = DB::table('class_session')->insertGetId([
            'section_id' => $sectionA,
            'period_id' => 1,
            'opened_by_id' => $teacherId,
            'session_date' => '2026-03-10',
            'status' => 'Closed',
        ]);

        $session2 = DB::table('class_session')->insertGetId([
            'section_id' => $sectionA,
            'period_id' => 1,
            'opened_by_id' => $teacherId,
            'session_date' => '2026-03-12',
            'status' => 'Closed',
        ]);

        DB::table('attendance')->insert([
            [
                'session_id' => $session1,
                'student_id' => $studentA,
                'registered_by_id' => $teacherId,
                'attendance_status' => 'Present',
                'registration_method' => 'QR',
            ],
            [
                'session_id' => $session2,
                'student_id' => $studentA,
                'registered_by_id' => $teacherId,
                'attendance_status' => 'Absent',
                'registration_method' => 'Manual',
            ],
        ]);

        $response = $this->withSession(['user_id' => $studentA])
            ->get(route('dashboard.estudiante'));

        $response->assertOk();
        $response->assertSee('Carlos Mendoza');
        $response->assertSee('V-28.123.456');
        $response->assertSee('UNEFA-2022-04921');
        $response->assertSee('SIS-701');
        $response->assertSee('Sistemas Distribuidos');
        $response->assertSee('1/2 asistidas');
        $response->assertSee('18.00');

        // Aislamiento estricto: no debe exponer datos del otro estudiante.
        $response->assertDontSee('Otro Alumno');
        $response->assertDontSee('SEC-999');
        $response->assertDontSee('Materia Privada Tercero');
    }

    public function test_rechaza_filtro_con_payload_sqli_o_xss(): void
    {
        $studentId = $this->createUserWithRole('Student', '28123457', 'Maria', 'Lopez', 'maria@unefa.edu.ve');

        $response = $this->withSession(['user_id' => $studentId])
            ->get(route('dashboard.estudiante', ['subject_code' => "' OR 1=1 --"]));

        $response->assertSessionHasErrors('subject_code');
    }

    public function test_registra_justificativo_sanitizando_xss_y_validando_pertenencia(): void
    {
        Storage::fake('local');

        $teacherId = $this->createUserWithRole('Teacher', '17555444', 'Luis', 'Sanchez', 'luis@unefa.edu.ve');
        $studentId = $this->createUserWithRole('Student', '28666777', 'Ana', 'Torres', 'ana@unefa.edu.ve');

        $subjectOther = DB::table('subject')->insertGetId([
            'career_id' => 1,
            'subject_code' => 'TEL-703',
            'subject_name' => 'Redes II',
            'semester' => 7,
            'credit_units' => 4,
            'display_order' => 1,
        ]);

        $sectionOther = DB::table('section')->insertGetId([
            'subject_id' => $subjectOther,
            'teacher_id' => $teacherId,
            'period_id' => 1,
            'section_name' => '07S-N1',
            'classroom' => 'Aula C-10',
            'status' => 'Active',
        ]);

        $foreignSessionId = DB::table('class_session')->insertGetId([
            'section_id' => $sectionOther,
            'period_id' => 1,
            'opened_by_id' => $teacherId,
            'session_date' => '2026-03-15',
            'status' => 'Closed',
        ]);

        // Intento de referenciar una sesion ajena (no inscrito): debe fallar.
        $forbiddenSessionResponse = $this->withSession(['user_id' => $studentId])
            ->post(route('dashboard.estudiante.justificativos.store'), [
                'session_id' => $foreignSessionId,
                'file_type' => 'PDF',
                'document' => UploadedFile::fake()->create('reposo.pdf', 120, 'application/pdf'),
                'observations' => 'Reposo medico emitido por el seguro social.',
            ]);

        $forbiddenSessionResponse->assertSessionHasErrors('session_id');

        // Envio valido con intento de XSS en observaciones: debe sanitizarse a texto plano.
        $validResponse = $this->withSession(['user_id' => $studentId])
            ->post(route('dashboard.estudiante.justificativos.store'), [
                'file_type' => 'PDF',
                'document' => UploadedFile::fake()->create('reposo_medico.pdf', 120, 'application/pdf'),
                'observations' => '<script>alert("xss")</script><b>Reposo medico</b> por consulta de emergencia.',
            ]);

        $validResponse->assertRedirect(route('dashboard.estudiante'));
        $validResponse->assertSessionHas('student_status');

        $doc = DB::table('document_registration')->where('user_id', $studentId)->first();
        $this->assertNotNull($doc);
        $this->assertSame('Pending', $doc->status);
        $this->assertSame('Reposo medico por consulta de emergencia.', $doc->observations);
        $this->assertStringNotContainsString('<script>', $doc->observations);
    }

    public function test_reglas_exactas_de_campos_del_departamento_backend(): void
    {
        $rules = (new UpdateStudentProfileRequest())->rules();

        $invalidValidator = Validator::make([
            'id_number' => 'V-28.123.456',
            'first_name' => 'Carlos123',
            'last_name' => 'Mendoza!',
            'email' => 'correo-invalido',
            'password' => 'abc12345@', // sin mayuscula y simbolo fuera de #$/&+/
        ], $rules);

        $this->assertTrue($invalidValidator->fails());
        $this->assertArrayHasKey('id_number', $invalidValidator->errors()->toArray());
        $this->assertArrayHasKey('first_name', $invalidValidator->errors()->toArray());
        $this->assertArrayHasKey('last_name', $invalidValidator->errors()->toArray());
        $this->assertArrayHasKey('email', $invalidValidator->errors()->toArray());
        $this->assertArrayHasKey('password', $invalidValidator->errors()->toArray());

        $validValidator = Validator::make([
            'id_number' => '28123456',
            'first_name' => 'Carlos',
            'last_name' => 'Mendoza',
            'email' => 'carlos.mendoza@unefa.edu.ve',
            'password' => 'Unefa2026#',
        ], $rules);

        $this->assertFalse($validValidator->fails());
        $this->assertSame('Texto limpio', StudentInputSanitizer::plainText('<img src=x onerror=alert(1)>Texto limpio'));
    }

    private function createUserWithRole(
        string $roleName,
        string $idNumber,
        string $firstName,
        string $lastName,
        string $email,
        ?string $credentialNumber = null
    ): int {
        $profileId = DB::table('profile')->insertGetId([
            'career_id' => 1,
            'id_number' => $idNumber,
            'id_type' => 'V',
            'first_name' => $firstName,
            'last_name' => $lastName,
            'current_semester' => 7,
            'has_dragged_subjects' => false,
        ]);

        $userId = DB::table('user_account')->insertGetId([
            'profile_id' => $profileId,
            'username' => strtolower($firstName.'.'.$idNumber),
            'email' => $email,
            'password_hash' => bcrypt('Unefa2026#'),
            'qr_token' => 'QR-TOKEN-'.$idNumber,
            'status' => 'Approved',
        ]);

        $roleId = (int) DB::table('system_role')->where('role_name', $roleName)->value('id');

        DB::table('user_role')->insert([
            'user_id' => $userId,
            'role_id' => $roleId,
            'is_active' => true,
            'credential_number' => $credentialNumber,
            'credential_issued_at' => now(),
        ]);

        return $userId;
    }
}
