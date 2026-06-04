<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    // 1. Beri tahu Laravel kalau Primary Key-nya adalah 'nis', bukan 'id'
    protected $primaryKey = 'nis';

    // 2. Beri tahu Laravel kalau Primary Key ini bertipe String dan bukan Auto Increment
    public $incrementing = false;
    protected $keyType = 'string';

    // 3. Kolom yang boleh diisi (Mass Assignment Protection)
    protected $fillable = ['nis', 'nama', 'alamat'];
}