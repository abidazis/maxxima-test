<?php
namespace App\Http\Controllers;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MataPelajaranController extends Controller
{
    // READ: Tampilkan semua mata pelajaran
    public function index() {
        return Inertia::render('DataMatpel', ['dataMatpel' => MataPelajaran::all()]);
    }

    // CREATE: Simpan mata pelajaran baru
    public function store(Request $request) {
        $request->validate(['nama_matpel' => 'required|string|max:50']);
        MataPelajaran::create($request->all());
        return redirect()->back();
    }

    // UPDATE: Edit mata pelajaran
    public function update(Request $request, $id)
    {
        $request->validate(['nama_matpel' => 'required|string|max:50']);
        $matpel = MataPelajaran::findOrFail($id);
        $matpel->update(['nama_matpel' => $request->nama_matpel]);
        return redirect()->back();
    }

        // DELETE: Hapus mata pelajaran
    public function destroy($id) {
        MataPelajaran::findOrFail($id)->delete();
        return redirect()->back();
    }
}