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
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap record peserta ujian
            
            // Foreign key ke tabel ujian
            $table->unsignedBigInteger('id_ujian');
            $table->foreign('id_ujian')->references('id_ujian')->on('ujians')->onDelete('cascade');
            
            // Foreign key ke tabel siswa
            $table->string('nis', 20);
            $table->foreign('nis')->references('nis')->on('siswas')->onDelete('cascade');
            
            // FITUR TAMBAHAN UNTUK MENJAWAB SOAL NO.2 (Penentu Kelulusan)
            $table->boolean('status_lulus')->default(false); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
