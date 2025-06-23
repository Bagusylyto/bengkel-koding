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
        Schema::create('periksas', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('id_pasien');
            // $table->unsignedBigInteger('id_dokter');
            $table->unsignedBigInteger('id_daftar_poli');
            $table->dateTime('tgl_periksa');
            $table->text('catatan')->nullable();
            $table->integer('biaya_periksa')->default(0);
            $table->timestamps();

            //Foreign key constraints
            // $table->foreign('id_pasien')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('id_dokter')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_daftar_poli')->references('id')->on('daftar_polis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksas');
    }
};
