<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    // READ: Tampilkan semua matpel
    public function index() {
        return response()->json(MataPelajaran::all());
    }

    // CREATE: Simpan matpel baru
    public function store(Request $request) {
        $request->validate(['nama_matpel' => 'required|string|max:50']);
        
        $matpel = MataPelajaran::create(['nama_matpel' => $request->nama_matpel]);
        return response()->json(['pesan' => 'Matpel tersimpan!', 'data' => $matpel]);
    }

    // UPDATE: Edit matpel
    public function update(Request $request, $id) {
        $matpel = MataPelajaran::findOrFail($id);
        $matpel->update(['nama_matpel' => $request->nama_matpel]);
        
        return response()->json(['pesan' => 'Matpel diupdate!', 'data' => $matpel]);
    }

    // DELETE: Hapus matpel
    public function destroy($id) {
        MataPelajaran::findOrFail($id)->delete();
        return response()->json(['pesan' => 'Matpel dihapus!']);
    }
}