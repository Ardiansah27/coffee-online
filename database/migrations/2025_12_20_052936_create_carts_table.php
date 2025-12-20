<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel users
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // Menghubungkan ke tabel menu_coffee (sesuai nama tabel di phpMyAdmin kamu)
        $table->foreignId('menu_id')->constrained('menu_coffee')->onDelete('cascade');
        $table->integer('quantity')->default(1);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
