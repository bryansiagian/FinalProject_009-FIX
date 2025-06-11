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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kode_pos');
            $table->unsignedBigInteger('wilayah_desa_id')->nullable();
            $table->foreign('wilayah_desa_id')->references('id')->on('wilayah_desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kode_pos', 10)->nullable(); // Kembalikan jika rollback
            $table->dropForeign(['wilayah_desa_id']);
            $table->dropColumn('wilayah_desa_id');
        });
    }
};