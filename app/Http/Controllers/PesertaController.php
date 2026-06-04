<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    // READ: Tampilkan semua peserta ujian
    public function index() {
        return response()->json(Peserta::all());
    }

    // CREATE: Daftarkan peserta ke ujian (Default status lulus = false/0)
    public function store(Request $request) {
        $request->validate([
            'id_ujian' => 'required|exists:ujians,id_ujian',
            'nis' => 'required|exists:siswas,nis',
        ]);
        
        $peserta = Peserta::create([
            'id_ujian' => $request->id_ujian,
            'nis' => $request->nis,
            'status_lulus' => false // Default saat mendaftar ujian belum lulus
        ]);
        
        return response()->json(['pesan' => 'Peserta ujian terdaftar!', 'data' => $peserta]);
    }

    // UPDATE: Update status kelulusan peserta (Menjawab Soal Operasi Kelulusan)
    public function update(Request $request, $id) {
        $peserta = Peserta::findOrFail($id);
        
        // Logika bisnis: Update hanya status kelulusan (true = 1, false = 0)
        $peserta->update([
            'status_lulus' => $request->status_lulus 
        ]);
        
        return response()->json(['pesan' => 'Status kelulusan diupdate!', 'data' => $peserta]);
    }

    // DELETE: Hapus peserta dari ujian
    public function destroy($id) {
        Peserta::findOrFail($id)->delete();
        return response()->json(['pesan' => 'Peserta dibatalkan dari ujian!']);
    }
}