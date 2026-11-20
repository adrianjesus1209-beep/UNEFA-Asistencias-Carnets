<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnefaInitialDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_role')->insertOrIgnore([
            [
                'id' => 1,
                'role_name' => 'Super Administrator',
                'hierarchy_level' => 1,
                'description' => 'Soporte Tecnico Central / TI - Acceso exclusivo a Auditoria, Bitacora y Configuracion Global',
            ],
            [
                'id' => 2,
                'role_name' => 'Director',
                'hierarchy_level' => 2,
                'description' => 'Rector / Administrador de la Institucion - Asigna Coordinadores de Carrera y valida con clave secundaria',
            ],
            [
                'id' => 3,
                'role_name' => 'Academic Coordinator',
                'hierarchy_level' => 3,
                'description' => 'Control de Estudios - Valida Expedientes, Registra Horarios y Emite Carnets Digitales',
            ],
            [
                'id' => 4,
                'role_name' => 'Teacher',
                'hierarchy_level' => 4,
                'description' => 'Docente / Titular de Materia - Gestiona Sesiones de Clase y Asistencias mediante Escaneo QR',
            ],
            [
                'id' => 5,
                'role_name' => 'Student',
                'hierarchy_level' => 5,
                'description' => 'Alumno Regular Aprobado - Acceso a Carnet Digital, QR y Horario Academico',
            ],
        ]);

        DB::table('permission')->insertOrIgnore([
            ['id' => 1, 'permission_key' => 'audit.view', 'permission_name' => 'Ver Bitacora y Auditoria', 'module' => 'Seguridad', 'description' => 'Acceso al registro de auditoria del sistema'],
            ['id' => 2, 'permission_key' => 'system.backup', 'permission_name' => 'Gestionar Respaldos', 'module' => 'Seguridad', 'description' => 'Ejecutar y descargar respaldos de base de datos'],
            ['id' => 3, 'permission_key' => 'coordinator.assign', 'permission_name' => 'Asignar Coordinadores', 'module' => 'Direccion', 'description' => 'Asignar coordinadores de carrera con clave secundaria'],
            ['id' => 4, 'permission_key' => 'metrics.global', 'permission_name' => 'Ver Metricas Globales', 'module' => 'Direccion', 'description' => 'Visualizar estadisticas institucionales'],
            ['id' => 5, 'permission_key' => 'student.validate_docs', 'permission_name' => 'Validar Expedientes', 'module' => 'Coordinacion', 'description' => 'Aprobar o rechazar documentos de estudiantes'],
            ['id' => 6, 'permission_key' => 'credential.issue', 'permission_name' => 'Emitir Carnets', 'module' => 'Coordinacion', 'description' => 'Autorizar y emitir carnets por rol'],
            ['id' => 7, 'permission_key' => 'schedule.manage', 'permission_name' => 'Gestionar Horarios y Secciones', 'module' => 'Coordinacion', 'description' => 'Crear secciones, asignar docentes e inscribir alumnos'],
            ['id' => 8, 'permission_key' => 'session.manage', 'permission_name' => 'Abrir y Cerrar Clases', 'module' => 'Docencia', 'description' => 'Iniciar y finalizar sesiones de clase'],
            ['id' => 9, 'permission_key' => 'attendance.scan', 'permission_name' => 'Escanear QR y Registrar Asistencia', 'module' => 'Docencia', 'description' => 'Pasar asistencia mediante lector QR o manual'],
            ['id' => 10, 'permission_key' => 'credential.view_own', 'permission_name' => 'Ver Carnets Propios y QR', 'module' => 'General', 'description' => 'Visualizar carnets activos asociados a sus roles'],
            ['id' => 11, 'permission_key' => 'schedule.view_own', 'permission_name' => 'Ver Horario y Materias', 'module' => 'Estudiantes', 'description' => 'Consultar horario inscrito y record de materias'],
        ]);

        DB::table('role_permission')->insertOrIgnore([
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],
            ['role_id' => 1, 'permission_id' => 6],
            ['role_id' => 1, 'permission_id' => 7],
            ['role_id' => 1, 'permission_id' => 8],
            ['role_id' => 1, 'permission_id' => 9],
            ['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],
            ['role_id' => 2, 'permission_id' => 3],
            ['role_id' => 2, 'permission_id' => 4],
            ['role_id' => 2, 'permission_id' => 10],
            ['role_id' => 3, 'permission_id' => 4],
            ['role_id' => 3, 'permission_id' => 5],
            ['role_id' => 3, 'permission_id' => 6],
            ['role_id' => 3, 'permission_id' => 7],
            ['role_id' => 3, 'permission_id' => 10],
            ['role_id' => 4, 'permission_id' => 8],
            ['role_id' => 4, 'permission_id' => 9],
            ['role_id' => 4, 'permission_id' => 10],
            ['role_id' => 5, 'permission_id' => 10],
            ['role_id' => 5, 'permission_id' => 11],
        ]);

        DB::table('security_question')->insertOrIgnore([
            ['id' => 1, 'question_text' => '¿Cual es el nombre de tu primera mascota?'],
            ['id' => 2, 'question_text' => '¿Cual es tu ciudad de nacimiento?'],
            ['id' => 3, 'question_text' => '¿Cual es el segundo nombre de tu madre?'],
            ['id' => 4, 'question_text' => '¿Cual fue tu primer colegio o escuela?'],
            ['id' => 5, 'question_text' => '¿Cual es tu comida favorita?'],
        ]);

        DB::table('career')->insertOrIgnore([
            [
                'id' => 1,
                'career_code' => 'SYS-ING',
                'career_name' => 'Ingenieria de Sistemas',
                'coordinator_id' => null,
            ],
        ]);

        DB::table('academic_period')->insertOrIgnore([
            [
                'id' => 1,
                'period_name' => '2026-1',
                'start_date' => '2026-02-01',
                'end_date' => '2026-06-30',
                'duration_weeks' => 16,
                'status' => 'Active',
            ],
        ]);

        // Usuario Administrador Base (admin / admin123)
        DB::table('profile')->insertOrIgnore([
            [
                'id' => 1,
                'career_id' => 1,
                'id_number' => '00000000',
                'id_type' => 'V',
                'first_name' => 'Administrador',
                'middle_name' => 'Principal',
                'last_name' => 'Sistemas',
                'second_last_name' => 'UNEFA',
                'current_semester' => 1,
                'has_dragged_subjects' => false,
                'address' => 'Sede Central UNEFA',
                'phone' => '04120000000',
                'job_title' => 'Super Administrador TI',
                'profile_picture' => 'default.svg',
            ],
        ]);

        DB::table('user_account')->insertOrIgnore([
            [
                'id' => 1,
                'profile_id' => 1,
                'username' => 'admin',
                'email' => 'admin@unefa.edu.ve',
                'password_hash' => '$2y$10$peaPjpuh3tDAveT2cTWmYuiAZETwJgHADt26P.O71DxxGoN/Be0D.',
                'qr_token' => 'UNEFA-QR-V00000000',
                'security_pin_hash' => null,
                'pin_expires_at' => null,
                'pin_updated_at' => null,
                'status' => 'Approved',
            ],
        ]);

        DB::table('user_role')->insertOrIgnore([
            [
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
                'is_active' => true,
                'credential_number' => 'CARNET-ADMIN-0001',
                'credential_issued_at' => now(),
                'credential_expires_at' => now()->addYear(),
            ],
        ]);
    }
}
