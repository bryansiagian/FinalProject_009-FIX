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
        Schema::create('wilayah_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('ongkos_kirim', 10, 2)->default(0);
            $table->boolean('tersedia_delivery')->default(false);
            $table->string('kode_pos', 10)->nullable(); // Simpan sebagai referensi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_desa');
    }
};