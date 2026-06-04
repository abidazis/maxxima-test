<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';
    
    // Beri tahu Laravel primary key-nya custom (bukan 'id')
    protected $primaryKey = 'id_matpel'; 

    protected $fillable = ['nama_matpel'];
}