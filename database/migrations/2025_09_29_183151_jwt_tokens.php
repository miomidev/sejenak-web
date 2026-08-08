<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // simpan hash dari access token
            $table->string('token', 500)->unique();
            $table->string('refresh_token', 500)->unique();

            $table->timestamp('expires_at');    // kapan JWT habis
            $table->timestamp('last_used_at')->nullable();

            // opsional tracking
            $table->string('device_name')->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
