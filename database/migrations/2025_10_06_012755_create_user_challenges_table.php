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
        Schema::create('user_challenges', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('daily_challenge_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->boolean('is_completed')->default(false);
    $table->timestamp('completed_at')->nullable();
    $table->timestamps();

    $table->unique(['user_id', 'daily_challenge_id', 'date']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_challenges');
    }
};
