<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AlgorithmController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\PesertaController;

// ==========================================
// 1. ROUTE PUBLIK (Bisa diakses tanpa Login)
// ==========================================
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Jalur untuk mengecek hasil Algoritma (Soal No. 4)
Route::get('/tes-fibonacci', [AlgorithmController::class, 'tampilFibonacci']);
Route::get('/tes-sort', [AlgorithmController::class, 'sortManual']);
Route::get('/tes-minmax', [AlgorithmController::class, 'cariMinMax']);
Route::get('/tes-umur', [AlgorithmController::class, 'hitungUmur']);


// ==========================================
// 2. ROUTE TERPROTEKSI (Wajib Login)
// ==========================================
// Middleware 'auth' memastikan user akan ditendang ke halaman Login jika belum masuk
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Halaman Dashboard bawaan Breeze
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Route untuk menampilkan halaman Frontend Vue Laporan Kelulusan (Soal No. 3)
    Route::get('/laporan-kelulusan', [PesertaController::class, 'laporanKelulusan'])->name('laporan.kelulusan');

    // Kumpulan API CRUD (Soal No. 1 & 2)
    Route::resource('siswa', SiswaController::class);
    Route::resource('matpel', MataPelajaranController::class);
    Route::resource('ujian', UjianController::class);
    Route::resource('peserta', PesertaController::class);
});

// 3. ROUTE PROFILE BAWAAN BREEZE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ROUTE KHUSUS ALGORITMA (Aman dari CRUD)
Route::get('/algoritma', [AlgorithmController::class, 'index'])->name('algoritma.index');
Route::post('/algoritma/fibonacci', [AlgorithmController::class, 'prosesFibonacci'])->name('algoritma.fibo');
Route::post('/algoritma/sort', [AlgorithmController::class, 'prosesSort'])->name('algoritma.sort');
Route::post('/algoritma/minmax', [AlgorithmController::class, 'prosesMinMax'])->name('algoritma.minmax');
Route::post('/algoritma/umur', [AlgorithmController::class, 'prosesUmur'])->name('algoritma.umur');

require __DIR__.'/auth.php';