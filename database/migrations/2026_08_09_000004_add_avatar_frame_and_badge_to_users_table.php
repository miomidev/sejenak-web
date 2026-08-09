<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar_frame')) {
                $table->string('avatar_frame')->default('default')->nullable();
            }
            if (!Schema::hasColumn('users', 'profile_badge')) {
                $table->string('profile_badge')->default('mindful')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar_frame')) {
                $table->dropColumn('avatar_frame');
            }
            if (Schema::hasColumn('users', 'profile_badge')) {
                $table->dropColumn('profile_badge');
            }
        });
    }
};
