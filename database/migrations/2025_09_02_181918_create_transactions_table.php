<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // ID unik untuk setiap order
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('package_name'); // Nama paket (e.g., Paket Basic)
            $table->integer('token_amount'); // Jumlah token yang dibeli
            $table->bigInteger('price'); // Harga paket
            $table->enum('status', ['pending', 'success', 'failed', 'expired']);
            $table->string('snap_token')->nullable(); // Token untuk menampilkan Midtrans Snap
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};