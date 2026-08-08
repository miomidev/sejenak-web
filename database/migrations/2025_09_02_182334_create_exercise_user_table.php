<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercise_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['started', 'completed'])->default('started');
            $table->timestamps();
            
            $table->unique(['exercise_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_user');
    }
};