<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_templates', function (Blueprint $table) {
            $table->id();
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
            $table->string('mood_trigger')->nullable()->comment('Mood yang memicu task ini muncul');
            $table->integer('points')->default(10)->comment('Poin hadiah selesai task');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_templates');
    }
};
