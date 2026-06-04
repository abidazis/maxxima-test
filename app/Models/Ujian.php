<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujians';
    
    // Primary key custom
    protected $primaryKey = 'id_ujian';

    // Foreign key id_matpel diizinkan diisi
    protected $fillable = ['nama_ujian', 'id_matpel', 'tanggal'];
}