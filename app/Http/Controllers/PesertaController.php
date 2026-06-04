<?php

namespace App\Http\Controllers;
use App\Models\Peserta;
use App\Models\Siswa;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index() {
        // Data tabel peserta (tetap sama)
        $peserta = DB::table('pesertas')
            ->join('siswas', 'pesertas.nis', '=', 'siswas.nis')
            ->join('ujians', 'pesertas.id_ujian', '=', 'ujians.id_ujian')
            ->select('pesertas.*', 'siswas.nama', 'ujians.nama_ujian')->get();
            
        // KUNCI SOLUSINYA DI SINI: Kita joinkan Ujian dengan Matpel agar namanya lengkap!
        $ujianLengkap = DB::table('ujians')
            ->join('mata_pelajarans', 'ujians.id_matpel', '=', 'mata_pelajarans.id_matpel')
            ->select('ujians.id_ujian', 'ujians.nama_ujian', 'mata_pelajarans.nama_matpel')
            ->get();

        return Inertia::render('DataPeserta', [
            'dataPeserta' => $peserta,
            'dataSiswa' => Siswa::all(),
            'dataUjian' => $ujianLengkap // Lempar data yang sudah di-join ke Vue
        ]);
    }

    public function store(Request $request) {
        $request->validate(['id_ujian' => 'required', 'nis' => 'required']);
        Peserta::create(['id_ujian' => $request->id_ujian, 'nis' => $request->nis, 'status_lulus' => false]);
        return redirect()->back();
    }

    public function update(Request $request, $id) {
        // Toggle status kelulusan
        $peserta = Peserta::findOrFail($id);
        $peserta->update(['status_lulus' => $request->status_lulus]);
        return redirect()->back();
    }

    public function destroy($id) {
        Peserta::findOrFail($id)->delete();
        return redirect()->back();
    }

    // MENJAWAB SOAL NO. 3 (MENAMPILKAN LAPORAN KELULUSAN)
    public function laporanKelulusan()
    {
        // 3a. Menampilkan Ujian berdasarkan TANGGAL (Diurutkan dari terbaru)
        $ujianByTanggal = DB::table('ujians')
            ->join('mata_pelajarans', 'ujians.id_matpel', '=', 'mata_pelajarans.id_matpel')
            ->orderBy('ujians.tanggal', 'desc')
            ->get();

        // 3b. Menampilkan NAMA_UJIAN, NAMA_MATPEL, TANGGAL, JUMLAH_PESERTA + JUMLAH LULUS
        $rekapUjian = DB::table('ujians')
            ->join('mata_pelajarans', 'ujians.id_matpel', '=', 'mata_pelajarans.id_matpel')
            ->leftJoin('pesertas', 'ujians.id_ujian', '=', 'pesertas.id_ujian')
            ->select(
                'ujians.nama_ujian', 
                'mata_pelajarans.nama_matpel', 
                'ujians.tanggal', 
                DB::raw('count(pesertas.nis) as jumlah_peserta'),
                // PASTIKAN BARIS INI ADA DAN SUDAH DI-SAVE:
                DB::raw('COALESCE(SUM(CASE WHEN pesertas.status_lulus = 1 THEN 1 ELSE 0 END), 0) as jumlah_lulus')
            )
            ->groupBy('ujians.id_ujian', 'ujians.nama_ujian', 'mata_pelajarans.nama_matpel', 'ujians.tanggal')
            ->get();

        // 3c. Menampilkan Jumlah SISWA yang Lulus dalam semua Ujian
        // Asumsi: Kita hitung total record peserta yang status_lulus = 1
        $totalSiswaLulus = DB::table('pesertas')
            ->where('status_lulus', 1)
            ->count();

        // 3d. Menampilkan siswa yang TIDAK LULUS dan pada Mata Pelajaran apa
        $siswaGagal = DB::table('pesertas')
            ->join('siswas', 'pesertas.nis', '=', 'siswas.nis')
            ->join('ujians', 'pesertas.id_ujian', '=', 'ujians.id_ujian')
            ->join('mata_pelajarans', 'ujians.id_matpel', '=', 'mata_pelajarans.id_matpel')
            ->where('pesertas.status_lulus', 0) // Filter hanya yang gagal (0)
            ->select('siswas.nama', 'mata_pelajarans.nama_matpel', 'ujians.nama_ujian')
            ->get();

        // Lempar semua data ini ke Vue
        return Inertia::render('LaporanUjian', [
            'ujianByTanggal' => $ujianByTanggal,
            'rekapUjian' => $rekapUjian,
            'totalSiswaLulus' => $totalSiswaLulus,
            'siswaGagal' => $siswaGagal
        ]);
    }
}