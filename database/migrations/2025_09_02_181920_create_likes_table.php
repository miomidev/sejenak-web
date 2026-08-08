<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            
        });
        DB::statement('ALTER TABLE likes ADD CONSTRAINT chk_likes CHECK ((post_id IS NOT NULL AND comment_id IS NULL) OR (post_id IS NULL AND comment_id IS NOT NULL))');

    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
};