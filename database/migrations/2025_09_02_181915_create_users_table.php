<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['user', 'konselor', 'admin', 'super_admin']);
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('username')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password')->nullable();
    $table->string('google_id')->nullable()->unique();
    $table->string('verification_code')->nullable();
    $table->timestamp('verification_code_expires_at')->nullable();
    $table->integer('verification_requests_count')->default(0);
    $table->date('last_verification_request_at')->nullable();
    $table->string('avatar')->nullable();
    $table->text('bio')->nullable();

    // tambahan untuk Jetstream/Breeze
    $table->text('two_factor_secret')->nullable();
    $table->text('two_factor_recovery_codes')->nullable();
    $table->string('profile_photo_path', 2048)->nullable();
    $table->foreignId('current_team_id')->nullable();

    $table->foreignId('role_id')->constrained()->onDelete('cascade')->default(1);
    $table->integer('tokens_balance')->default(0);
    $table->boolean('is_suspended')->default(false);

    $table->rememberToken();
    $table->timestamps();
});


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
Schema::disableForeignKeyConstraints();

Schema::dropIfExists('sessions');
Schema::dropIfExists('password_reset_tokens');
Schema::dropIfExists('users');
Schema::dropIfExists('roles');

Schema::enableForeignKeyConstraints();

    }
};
