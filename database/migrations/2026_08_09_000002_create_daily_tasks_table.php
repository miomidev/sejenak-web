<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_template_id')->nullable()->constrained()->onDelete('set null');
            $table->date('date');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', [
                'daily_activity',
                'mental_recovery',
                'brain_refresh',
                'physical_health',
                'time_management',
                'self_discipline',
                'social_interaction',
                'mindfulness',
                'habit_building',
                'self_reflection'
            ]);
            $table->enum('type', ['in_app', 'off_app'])->default('in_app');
            $table->enum('source', ['mood', 'journal', 'template', 'ai'])->default('template')->comment('Sumber task di-generate');
            $table->integer('points')->default(10);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'task_template_id', 'date']);
            $table->index(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_tasks');
    }
};
