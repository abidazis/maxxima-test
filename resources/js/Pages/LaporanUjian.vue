<template>
    <div class="min-h-screen bg-gray-100 py-8 px-4">
        <div class="max-w-7xl mx-auto space-y-8">
            
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Laporan Akademik (Jawaban Soal 3)</h1>
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow">
                    <p class="text-sm font-semibold">Total Siswa Lulus Keseluruhan (3c)</p>
                    <p class="text-3xl font-bold text-center">{{ totalSiswaLulus }} <span class="text-sm">Siswa</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="space-y-8">
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-lg font-bold mb-4 border-b pb-2">3a. Ujian Berdasarkan Tanggal</h2>
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-2 text-left">Tanggal</th>
                                    <th class="py-2 px-2 text-left">Nama Ujian</th>
                                    <th class="py-2 px-2 text-left">Mata Pelajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in ujianByTanggal" :key="index" class="border-b">
                                    <td class="py-2 px-2">{{ item.tanggal }}</td>
                                    <td class="py-2 px-2 font-semibold">{{ item.nama_ujian }}</td>
                                    <td class="py-2 px-2">{{ item.nama_matpel }}</td>
                                </tr>
                                <tr v-if="ujianByTanggal.length === 0">
                                    <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data ujian.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-lg font-bold mb-4 border-b pb-2">3b. Rekap Ujian & Jumlah Peserta</h2>
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-2 px-2 text-left">Nama Ujian</th>
                                    <th class="py-2 px-2 text-left">Mata Pelajaran</th>
                                    <th class="py-2 px-2 text-left">Tanggal</th>
                                    <th class="py-2 px-2 text-center">Total Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in rekapUjian" :key="index" class="border-b">
                                    <td class="py-2 px-2 font-semibold">{{ item.nama_ujian }}</td>
                                    <td class="py-2 px-2">{{ item.nama_matpel }}</td>
                                    <td class="py-2 px-2">{{ item.tanggal }}</td>
                                    <td class="py-2 px-2 text-center">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-bold">{{ item.jumlah_peserta }}</span>
                                    </td>
                                </tr>
                                <tr v-if="rekapUjian.length === 0">
                                    <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data rekap.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-red-500">
                    <h2 class="text-lg font-bold mb-4 border-b pb-2 text-red-600">3d. Laporan Siswa Gagal Ujian</h2>
                    <table class="min-w-full text-sm">
                        <thead class="bg-red-50 text-red-700">
                            <tr>
                                <th class="py-2 px-2 text-left">Nama Siswa</th>
                                <th class="py-2 px-2 text-left">Gagal di Ujian</th>
                                <th class="py-2 px-2 text-left">Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in siswaGagal" :key="index" class="border-b">
                                <td class="py-2 px-2 font-bold">{{ item.nama }}</td>
                                <td class="py-2 px-2 text-red-600">{{ item.nama_ujian }}</td>
                                <td class="py-2 px-2">{{ item.nama_matpel }}</td>
                            </tr>
                            <tr v-if="siswaGagal.length === 0">
                                <td colspan="3" class="text-center py-8 text-gray-500 italic">
                                    Tida ada siswa yang gagal, atau data belum diinput.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
// Menangkap 4 jenis data yang dikirim dari Controller
defineProps({
    ujianByTanggal: Array,
    rekapUjian: Array,
    totalSiswaLulus: Number,
    siswaGagal: Array
});
</script>