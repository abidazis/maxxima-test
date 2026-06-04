<?php
namespace App\Http\Controllers;
use App\Models\Ujian;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UjianController extends Controller
{
    public function index() {
        $ujian = Ujian::join('mata_pelajarans', 'ujians.id_matpel', '=', 'mata_pelajarans.id_matpel')
            ->select('ujians.*', 'mata_pelajarans.nama_matpel')->get();
        return Inertia::render('DataUjian', ['dataUjian' => $ujian, 'dataMatpel' => MataPelajaran::all()]);
    }

    public function store(Request $request) {
        $request->validate(['nama_ujian' => 'required', 'id_matpel' => 'required', 'tanggal' => 'required']);
        Ujian::create($request->all());
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_ujian' => 'required|string|max:50', 'id_matpel' => 'required', 'tanggal' => 'required|date']);
        $ujian = Ujian::findOrFail($id);
        $ujian->update($request->all());
        return redirect()->back();
    }
    
    public function destroy($id) {
        Ujian::findOrFail($id)->delete();
        return redirect()->back();
    }
}