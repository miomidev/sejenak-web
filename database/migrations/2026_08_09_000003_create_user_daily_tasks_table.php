<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('daily_task_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'skipped'])->default('pending');
            $table->text('notes')->nullable()->comment('Catatan user saat menyelesaikan task');
            $table->integer('points_earned')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'daily_task_id']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_daily_tasks');
    }
};
