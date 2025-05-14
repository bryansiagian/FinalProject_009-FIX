<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gambar'); //Nama file gambar
            $table->string('path'); // Path ke file gambar (di dalam storage)
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Tambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL'); //Definisikan foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};