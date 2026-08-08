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
        Schema::create('challenge_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_challenge_id')->constrained()->onDelete('cascade');
        $table->text('notes')->nullable();
        $table->json('meta')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_logs');
    }
};
