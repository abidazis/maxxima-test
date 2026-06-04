<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'pesertas';
    
    // Primary key menggunakan default 'id' dari blueprint bawaan
    protected $fillable = ['id_ujian', 'nis', 'status_lulus'];
}