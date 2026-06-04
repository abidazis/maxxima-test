<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    // READ: Tampilkan semua ujian
    public function index() {
        return response()->json(Ujian::all());
    }

    // CREATE: Simpan ujian baru
    public function store(Request $request) {
        $request->validate([
            'nama_ujian' => 'required|string|max:50',
            'id_matpel' => 'required|exists:mata_pelajarans,id_matpel', // Pastikan matpel ada di database
            'tanggal' => 'required|date'
        ]);
        
        $ujian = Ujian::create($request->all());
        return response()->json(['pesan' => 'Ujian tersimpan!', 'data' => $ujian]);
    }

    // UPDATE: Edit ujian
    public function update(Request $request, $id) {
        $ujian = Ujian::findOrFail($id);
        $ujian->update($request->all());
        
        return response()->json(['pesan' => 'Ujian diupdate!', 'data' => $ujian]);
    }

    // DELETE: Hapus ujian
    public function destroy($id) {
        Ujian::findOrFail($id)->delete();
        return response()->json(['pesan' => 'Ujian dihapus!']);
    }
}