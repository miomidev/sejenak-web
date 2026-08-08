<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('circle_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circle_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['member', 'moderator'])->default('member');
            $table->timestamps();
            
            $table->unique(['circle_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('circle_user');
    }
};