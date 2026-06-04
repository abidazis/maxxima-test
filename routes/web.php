<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\PesertaController;

// Route::resource akan otomatis membuatkan jalur untuk index, store, show, update, dan destroy!
Route::resource('siswa', SiswaController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('matpel', MataPelajaranController::class);
Route::resource('ujian', UjianController::class);
Route::resource('peserta', PesertaController::class);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
