<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject_id')->index('idx_ts_subject');
            $table->unsignedInteger('assigned_by_id')->nullable()->index('idx_ts_assigned_by');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['teacher_id', 'subject_id'], 'uniq_teacher_subject');
            $table->foreign('teacher_id', 'fk_ts_teacher')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('subject_id', 'fk_ts_subject')
                ->references('id')->on('subject')
                ->cascadeOnDelete();
            $table->foreign('assigned_by_id', 'fk_ts_assigned_by')
                ->references('id')->on('user_account')
                ->nullOnDelete();
        });

        Schema::create('section', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id')->index('idx_section_subject');
            $table->unsignedInteger('teacher_id')->index('idx_section_teacher');
            $table->unsignedInteger('period_id');
            $table->string('section_name', 30);
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
                ->default('Monday');
            $table->time('start_time')->default('08:00:00');
            $table->time('end_time')->default('10:00:00');
            $table->unsignedTinyInteger('tolerance_minutes')->default(15);
            $table->string('classroom', 50)->default('Aula 01');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            $table->index(['period_id', 'status'], 'idx_section_period_status');
            $table->index(['day_of_week', 'start_time'], 'idx_section_schedule');
            $table->foreign('subject_id', 'fk_section_subject')
                ->references('id')->on('subject')
                ->cascadeOnDelete();
            $table->foreign('teacher_id', 'fk_section_teacher')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('period_id', 'fk_section_period')
                ->references('id')->on('academic_period')
                ->cascadeOnDelete();
        });

        Schema::create('section_enrollment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('section_id')->index('idx_enrollment_section');
            $table->unsignedInteger('period_id')->index('idx_enrollment_period');
            $table->enum('status', ['Pending', 'Enrolled', 'Approved', 'Failed', 'Withdrawn', 'Rejected'])
                ->default('Pending')
                ->index('idx_enrollment_status');
            $table->boolean('is_dragged')->default(false);
            $table->unsignedTinyInteger('final_grade')->default(0);
            $table->boolean('validated_by_coordinator')->default(false);
            $table->boolean('is_cycle_closed')->default(false);
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['student_id', 'section_id'], 'uniq_student_section');
            $table->index(['student_id', 'status', 'is_dragged'], 'idx_enrollment_dragged');
            $table->foreign('student_id', 'fk_enroll_student')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('section_id', 'fk_enroll_section')
                ->references('id')->on('section')
                ->cascadeOnDelete();
            $table->foreign('period_id', 'fk_enroll_period')
                ->references('id')->on('academic_period')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_enrollment');
        Schema::dropIfExists('section');
        Schema::dropIfExists('teacher_subject');
    }
};
