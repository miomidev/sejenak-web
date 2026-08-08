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
        Schema::create('daily_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['in_app', 'off_app']);
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
            ])->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_challenges');
    }
};
