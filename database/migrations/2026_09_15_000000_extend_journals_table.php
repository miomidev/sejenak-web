<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('audio_path')->nullable()->after('content');
            $table->float('audio_duration')->nullable()->after('audio_path');
            $table->string('transcription_model')->nullable()->after('audio_duration');
            $table->float('transcription_confidence')->nullable()->after('transcription_model');
            $table->string('mood')->nullable()->after('transcription_confidence');
            $table->string('category')->nullable()->after('mood');
            $table->string('card_type')->nullable()->after('category');
            $table->boolean('is_voice_entry')->default(false)->after('card_type');
            $table->json('ai_metadata')->nullable()->after('is_voice_entry');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn([
                'audio_path',
                'audio_duration',
                'transcription_model',
                'transcription_confidence',
                'mood',
                'category',
                'card_type',
                'is_voice_entry',
                'ai_metadata',
            ]);
        });
    }
};
