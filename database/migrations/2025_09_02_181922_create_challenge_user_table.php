<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('challenge_user', function (Blueprint $table) {
    $table->foreignId('challenge_id');
    $table->foreignId('user_id');
    $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']); // Example enum values
    $table->timestamps();
    
    $table->primary(['challenge_id', 'user_id']);
});
    }

    public function down()
    {
        Schema::dropIfExists('challenge_user');
    }
};