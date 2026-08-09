<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->default('mindfulness'); // breathing, mindfulness, grounding, relaxation
            $table->enum('content_type', ['text', 'video'])->default('text');
            $table->text('description')->nullable();
            $table->longText('content')->nullable(); // Materi teks berbentuk artikel/blog
            $table->string('video_url')->nullable(); // Video URL (YouTube embed / MP4)
            $table->string('media_path')->nullable(); // Gambar sampul
            $table->string('author_name')->default('Konselor Sejenak');
            $table->integer('duration_minutes')->default(5);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};