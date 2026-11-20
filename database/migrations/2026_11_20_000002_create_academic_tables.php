<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career', function (Blueprint $table) {
            $table->increments('id');
            $table->string('career_code', 20)->unique('uniq_career_code');
            $table->string('career_name', 100);
            $table->unsignedInteger('coordinator_id')->nullable()->index('idx_career_coordinator');

            $table->foreign('coordinator_id', 'fk_career_coordinator')
                ->references('id')->on('user_account')
                ->nullOnDelete();
        });

        Schema::table('profile', function (Blueprint $table) {
            $table->foreign('career_id', 'fk_profile_career')
                ->references('id')->on('career')
                ->nullOnDelete();
        });

        Schema::create('subject', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('career_id')->nullable()->default(1);
            $table->string('subject_code', 20)->unique('uniq_subject_code');
            $table->string('subject_name', 100);
            $table->unsignedTinyInteger('semester')->nullable()->index('idx_subject_semester');
            $table->unsignedTinyInteger('credit_units')->default(3);
            $table->unsignedTinyInteger('display_order')->default(1);

            $table->index(['career_id', 'semester'], 'idx_subject_career_semester');
            $table->foreign('career_id', 'fk_subject_career')
                ->references('id')->on('career')
                ->nullOnDelete();
        });

        Schema::create('course_prerequisite', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('prerequisite_id')->index('idx_prereq_required');

            $table->unique(['subject_id', 'prerequisite_id'], 'uniq_subject_prereq');
            $table->foreign('subject_id', 'fk_prereq_subject')
                ->references('id')->on('subject')
                ->cascadeOnDelete();
            $table->foreign('prerequisite_id', 'fk_prereq_required')
                ->references('id')->on('subject')
                ->cascadeOnDelete();
        });

        Schema::create('academic_period', function (Blueprint $table) {
            $table->increments('id');
            $table->string('period_name', 50)->unique('uniq_period_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger('duration_weeks')->default(16);
            $table->enum('status', ['Active', 'Closed', 'Planned'])
                ->default('Active')
                ->index('idx_period_status');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('calendar_event', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('period_id');
            $table->unsignedSmallInteger('year');
            $table->string('category', 50);
            $table->string('description', 300);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['period_id', 'start_date', 'end_date'], 'idx_event_period_dates');
            $table->foreign('period_id', 'fk_event_period')
                ->references('id')->on('academic_period')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_event');
        Schema::dropIfExists('academic_period');
        Schema::dropIfExists('course_prerequisite');
        Schema::dropIfExists('subject');

        Schema::table('profile', function (Blueprint $table) {
            $table->dropForeign('fk_profile_career');
        });

        Schema::dropIfExists('career');
    }
};
