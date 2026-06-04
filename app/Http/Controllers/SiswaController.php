<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // ==========================================
    // READ (Menampilkan semua data siswa)
    // ==========================================
    public function index()
    {
        $siswa = Siswa::all(); // Mengambil semua isi tabel siswa
        // Jika pakai API/Vue, kita kembalikan data dalam bentuk JSON
        return response()->json([
            'pesan' => 'Data Siswa Berhasil Diambil',
            'data' => $siswa
        ]);
    }

    // ==========================================
    // CREATE (Menyimpan data siswa baru ke database)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Validasi inputan dari user (jangan sampai kosong)
        $request->validate([
            'nis' => 'required|unique:siswas,nis', // NIS tidak boleh sama
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
        ]);

        // 2. Simpan ke database
        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return response()->json([
            'pesan' => 'Siswa berhasil ditambahkan',
            'data' => $siswa
        ]);
    }

    // ==========================================
    // READ SPESIFIK (Menampilkan 1 data siswa berdasarkan NIS)
    // ==========================================
    public function show($nis)
    {
        // Cari siswa berdasarkan NIS, kalau tidak ada otomatis error 404
        $siswa = Siswa::findOrFail($nis); 
        return response()->json($siswa);
    }

    // ==========================================
    // UPDATE (Mengubah data siswa)
    // ==========================================
    public function update(Request $request, $nis)
    {
        // 1. Cari dulu data siswanya ada atau tidak
        $siswa = Siswa::findOrFail($nis);

        // 2. Update data siswanya dengan data baru dari inputan
        $siswa->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return response()->json([
            'pesan' => 'Data Siswa berhasil diubah',
            'data' => $siswa
        ]);
    }

    // ==========================================
    // DELETE (Menghapus data siswa)
    // ==========================================
    public function destroy($nis)
    {
        // 1. Cari data siswanya
        $siswa = Siswa::findOrFail($nis);
        
        // 2. Eksekusi hapus dari database
        $siswa->delete();

        return response()->json([
            'pesan' => 'Data Siswa berhasil dihapus'
        ]);
    }
}