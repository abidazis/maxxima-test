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
        Schema::create('ujians', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->string('nama_ujian', 50);
            
            // Foreign key ke tabel mata_pelajaran
            $table->unsignedBigInteger('id_matpel'); 
            $table->foreign('id_matpel')->references('id_matpel')->on('mata_pelajarans')->onDelete('cascade');
            
            $table->dateTime('tanggal'); // Penulisan typo di soal 'TANNGAL' kita perbaiki jadi 'tanggal'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
