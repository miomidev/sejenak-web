<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE consult_sessions MODIFY COLUMN status ENUM('pending', 'ongoing', 'completed', 'rejected', 'closed') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE consult_sessions MODIFY COLUMN status ENUM('ongoing', 'closed') NOT NULL DEFAULT 'ongoing'");
    }
};
