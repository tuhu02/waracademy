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
        Schema::create('kisi_kisi', function (Blueprint $table) {
            $table->id('id_kisi'); // primary key custom
            $table->unsignedBigInteger('level_id');
            $table->string('topik');
            $table->integer('jumlah_soal');
            $table->integer('waktu_menit');
            $table->string('jenis_soal'); // atau enum jika jenis_soal punya nilai tetap

            // Foreign key constraint (opsional tapi disarankan)
            $table->foreign('level_id')->references('id_level')->on('level')->onDelete('cascade');

            // Tidak ada timestamps karena $timestamps = false di model
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kisi_kisi');
    }
};