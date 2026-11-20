<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('action', 100)->index('idx_audit_action');
            $table->string('detail', 500)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent()->index('idx_audit_timestamp');

            $table->index(['user_id', 'created_at'], 'idx_audit_user_date');
            $table->foreign('user_id', 'fk_audit_user')
                ->references('id')->on('user_account')
                ->nullOnDelete();
        });

        Schema::create('failed_attempt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip_address', 45);
            $table->string('attempt_type', 20)->default('login');
            $table->string('identifier', 100)->nullable();
            $table->timestamp('attempted_at')->useCurrent();

            $table->index(['ip_address', 'attempt_type', 'attempted_at'], 'idx_failed_lookup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_attempt');
        Schema::dropIfExists('audit_log');
    }
};
