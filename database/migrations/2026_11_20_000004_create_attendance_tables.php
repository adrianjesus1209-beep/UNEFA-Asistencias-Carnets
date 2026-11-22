<?php

/**
 * Migracion 4: Control de sesiones de clase y asistencias.
 *
 * Crea las tablas para el pase de lista diario:
 * - class_session: apertura y cierre de sesiones de clase por seccion y semana.
 * - attendance: registro de asistencia por estudiante (Presente, Ausente,
 *   Justificado o Retardo) mediante escaneo QR o registro manual.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_session', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('period_id')->index('idx_session_period');
            $table->unsignedInteger('opened_by_id')->index('idx_session_opener');
            $table->date('session_date')->index('idx_session_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedTinyInteger('tolerance_minutes')->default(15);
            $table->enum('session_type', ['Regular', 'Extraordinary'])->default('Regular');
            $table->unsignedTinyInteger('week_number')->nullable();
            $table->enum('status', ['Open', 'Closed'])->default('Open');
            $table->string('observations', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['section_id', 'status', 'session_date'], 'idx_session_section_status');
            $table->foreign('section_id', 'fk_session_section')
                ->references('id')->on('section')
                ->cascadeOnDelete();
            $table->foreign('period_id', 'fk_session_period')
                ->references('id')->on('academic_period')
                ->cascadeOnDelete();
            $table->foreign('opened_by_id', 'fk_session_opener')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
        });

        Schema::create('attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('registered_by_id')->nullable()->index('idx_attendance_registrar');
            $table->enum('attendance_status', ['Present', 'Absent', 'Excused', 'Late'])->default('Present');
            $table->enum('registration_method', ['QR', 'Manual'])->default('QR')->index('idx_attendance_method');
            $table->string('observation', 255)->nullable();
            $table->timestamp('recorded_at')->useCurrent();

            $table->unique(['session_id', 'student_id'], 'uniq_session_student');
            $table->index(['student_id', 'attendance_status'], 'idx_attendance_student_status');
            $table->foreign('session_id', 'fk_attendance_session')
                ->references('id')->on('class_session')
                ->cascadeOnDelete();
            $table->foreign('student_id', 'fk_attendance_student')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('registered_by_id', 'fk_attendance_registrar')
                ->references('id')->on('user_account')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('class_session');
    }
};
