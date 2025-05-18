<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKodePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_pos', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pos', 10)->unique();
            $table->boolean('dalam_radius_delivery')->default(false);
            $table->unsignedDecimal('ongkos_kirim', 10, 2)->default(0.00); // Tambahkan kolom ongkos_kirim
            $table->unsignedBigInteger('user_id')->nullable(); // Added user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL'); // Foreign key relationship

            $table->unsignedBigInteger('updated_by')->nullable(); // User yang update terakhir
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kode_pos');
    }
}