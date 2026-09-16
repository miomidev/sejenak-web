<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('character_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ai_character_id')->constrained()->onDelete('cascade');
            $table->foreignId('journal_entry_id')->nullable()->constrained('journals')->onDelete('set null');
            $table->text('message');
            $table->boolean('is_from_character')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_conversations');
    }
};
