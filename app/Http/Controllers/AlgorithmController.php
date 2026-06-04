<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AlgorithmController extends Controller
{
    // Halaman UI Utama untuk Algoritma
    public function index() {
        return Inertia::render('Algoritma');
    }

    // 1. FIBONACCI (Rekursif)
    private function cariFibonacci($n) {
        if ($n == 0) return 0;
        if ($n == 1) return 1;
        return $this->cariFibonacci($n - 1) + $this->cariFibonacci($n - 2);
    }

    public function prosesFibonacci(Request $request) {
        $input = $request->input_angka ?? 5; // Default 5 jika kosong
        $hasil = [];
        for ($i = 0; $i <= $input; $i++) {
            $hasil[] = $this->cariFibonacci($i);
        }
        return response()->json(['output' => implode(', ', $hasil)]);
    }

    // 2. BUBBLE SORT (Pengurutan Manual)
    public function prosesSort(Request $request) {
        // Mengubah string "1,3,2,9,5" menjadi array [1, 3, 2, 9, 5]
        $stringInput = $request->input_array ?? '1, 3, 2, 9, 5';
        $array = array_map('intval', explode(',', $stringInput));
        $jumlahData = count($array);

        for ($i = 0; $i < $jumlahData; $i++) {
            for ($j = 0; $j < $jumlahData - 1; $j++) {
                if ($array[$j] < $array[$j + 1]) {
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return response()->json(['output' => implode(', ', $array)]);
    }

    // 3. CARI MIN/MAX MANUAL
    public function prosesMinMax(Request $request) {
        $stringInput = $request->input_array ?? '1, 3, 2, 9, 5';
        $array = array_map('intval', explode(',', $stringInput));
        $jenis = $request->jenis ?? 'max'; // 'max' atau 'min'

        $hasilEkstrim = $array[0];
        for ($i = 1; $i < count($array); $i++) {
            if ($jenis == 'max' && $array[$i] > $hasilEkstrim) {
                $hasilEkstrim = $array[$i];
            } else if ($jenis == 'min' && $array[$i] < $hasilEkstrim) {
                $hasilEkstrim = $array[$i];
            }
        }
        return response()->json(['output' => (string)$hasilEkstrim]);
    }
    
    // 4. MENGHITUNG UMUR & TAHUN KABISAT
    public function prosesUmur(Request $request) {
        $inputTanggal = $request->input_tanggal ?? '08-12-1990'; // Format mm-dd-yyyy
        
        // Parsing input menjadi object DateTime
        $tanggalLahir = new \DateTime($inputTanggal);
        $tanggalSekarang = new \DateTime(); // Mengambil waktu server saat ini
        
        // A. Hitung Umur (Tahun, Bulan, Hari)
        $selisih = $tanggalSekarang->diff($tanggalLahir);
        $umur = "{$selisih->y} tahun, {$selisih->m} bulan, {$selisih->d} hari";

        // B. Hitung Tahun Kabisat Terlewati
        $tahunLahir = (int) $tanggalLahir->format('Y');
        $tahunSekarang = (int) $tanggalSekarang->format('Y');
        $jumlahKabisat = 0;

        // Looping dari tahun lahir sampai tahun ini
        for ($tahun = $tahunLahir; $tahun <= $tahunSekarang; $tahun++) {
            // Syarat Kabisat: Habis dibagi 4 TAPI tidak habis dibagi 100, ATAU habis dibagi 400
            if (($tahun % 4 == 0 && $tahun % 100 != 0) || ($tahun % 400 == 0)) {
                $jumlahKabisat++;
            }
        }

        return response()->json([
            'umur' => $umur,
            'kabisat' => $jumlahKabisat . ' tahun kabisat'
        ]);
    }
}