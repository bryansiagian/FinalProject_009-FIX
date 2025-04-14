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
        Schema::create('tentang_kami', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko')->nullable();
            $table->text('alamat')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(false); // Menandai record yang aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tentang_kami');
    }
};
