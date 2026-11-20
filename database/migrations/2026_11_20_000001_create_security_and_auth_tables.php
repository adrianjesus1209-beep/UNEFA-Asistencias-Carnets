<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name', 50)->unique('uniq_role_name');
            $table->unsignedTinyInteger('hierarchy_level')->index('idx_role_hierarchy');
            $table->string('description', 255);
        });

        Schema::create('permission', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permission_key', 80)->unique('uniq_permission_key');
            $table->string('permission_name', 100);
            $table->string('module', 50)->index('idx_permission_module');
            $table->string('description', 255)->nullable();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id')->index('idx_rp_permission');

            $table->unique(['role_id', 'permission_id'], 'uniq_role_permission');
            $table->foreign('role_id', 'fk_rp_role')
                ->references('id')->on('system_role')
                ->cascadeOnDelete();
            $table->foreign('permission_id', 'fk_rp_permission')
                ->references('id')->on('permission')
                ->cascadeOnDelete();
        });

        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('career_id')->nullable()->index('idx_profile_career');
            $table->string('id_number', 20)->unique('uniq_id_number');
            $table->string('id_type', 2)->default('V');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->unsignedTinyInteger('current_semester')->default(1);
            $table->boolean('has_dragged_subjects')->default(false);
            $table->string('address', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index(['current_semester', 'has_dragged_subjects'], 'idx_profile_semester');
        });

        Schema::create('user_account', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id')->unique('uniq_profile_id');
            $table->string('username', 100)->unique('uniq_username');
            $table->string('email', 100)->unique('uniq_email');
            $table->string('password_hash', 255);
            $table->string('qr_token', 128)->unique('uniq_user_qr_token');
            $table->string('security_pin_hash', 255)->nullable();
            $table->dateTime('pin_expires_at')->nullable()->index('idx_user_pin_expiration');
            $table->dateTime('pin_updated_at')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Inactive'])
                ->default('Pending')
                ->index('idx_user_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('profile_id', 'fk_user_profile')
                ->references('id')->on('profile')
                ->cascadeOnDelete();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->boolean('is_active')->default(true);
            $table->string('credential_number', 50)->nullable()->unique('uniq_credential_number');
            $table->dateTime('credential_issued_at')->nullable();
            $table->dateTime('credential_expires_at')->nullable();
            $table->timestamp('assigned_at')->useCurrent();

            $table->unique(['user_id', 'role_id'], 'uniq_user_role');
            $table->index(['role_id', 'is_active'], 'idx_ur_role_active');
            $table->foreign('user_id', 'fk_ur_user')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('role_id', 'fk_ur_role')
                ->references('id')->on('system_role')
                ->restrictOnDelete();
        });

        Schema::create('security_question', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question_text', 255);
        });

        Schema::create('user_security_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('question_id')->index('idx_answer_question');
            $table->string('answer_hash', 255);

            $table->unique(['user_id', 'question_id'], 'uniq_user_question');
            $table->foreign('user_id', 'fk_answer_user')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
            $table->foreign('question_id', 'fk_answer_question')
                ->references('id')->on('security_question')
                ->cascadeOnDelete();
        });

        Schema::create('verification_code', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('code', 10)->index('idx_vc_code');
            $table->enum('code_type', ['2FA_Login', 'Password_Reset', 'Security_Questions_Reset', 'Pin_Reset'])
                ->default('Password_Reset');
            $table->dateTime('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'code_type', 'is_used', 'expires_at'], 'idx_vc_lookup');
            $table->foreign('user_id', 'fk_vc_user')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
        });

        Schema::create('document_registration', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->enum('file_type', ['Word', 'PDF', 'Image', 'Excel'])->default('PDF');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])
                ->default('Pending')
                ->index('idx_doc_status');
            $table->string('observations', 500)->nullable();
            $table->timestamp('uploaded_at')->useCurrent();

            $table->index(['user_id', 'status'], 'idx_doc_user_status');
            $table->foreign('user_id', 'fk_doc_user')
                ->references('id')->on('user_account')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_registration');
        Schema::dropIfExists('verification_code');
        Schema::dropIfExists('user_security_answer');
        Schema::dropIfExists('security_question');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_account');
        Schema::dropIfExists('profile');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permission');
        Schema::dropIfExists('system_role');
    }
};
