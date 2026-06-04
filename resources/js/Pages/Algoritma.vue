<template>
    <div class="min-h-screen bg-gray-100 py-8 px-4">
        <div class="max-w-4xl mx-auto space-y-6">
            <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">Mini-Apps Algoritma Dasar</h1>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-indigo-500">
                <h2 class="text-xl font-bold mb-4">1. Aplikasi Deret Fibonacci (Rekursif)</h2>
                <div class="flex gap-4">
                    <input v-model="fiboInput" type="number" class="border p-2 rounded w-full" placeholder="Masukkan batas n (contoh: 5)">
                    <button @click="hitungFibo" class="bg-indigo-500 text-white px-4 py-2 rounded font-bold hover:bg-indigo-600">Proses</button>
                </div>
                <div v-if="fiboHasil" class="mt-4 p-3 bg-gray-100 rounded text-lg font-mono">Output: <span class="text-indigo-600 font-bold">{{ fiboHasil }}</span></div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <h2 class="text-xl font-bold mb-4">2. Aplikasi Pengurutan (Bubble Sort Manual)</h2>
                <div class="flex gap-4">
                    <input v-model="sortInput" type="text" class="border p-2 rounded w-full" placeholder="Masukkan angka pisahkan koma (contoh: 3, 7, -3, 5, 9, 5)">
                    <button @click="hitungSort" class="bg-green-500 text-white px-4 py-2 rounded font-bold hover:bg-green-600">Urutkan</button>
                </div>
                <div v-if="sortHasil" class="mt-4 p-3 bg-gray-100 rounded text-lg font-mono">Output Terurut: <span class="text-green-600 font-bold">{{ sortHasil }}</span></div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                <h2 class="text-xl font-bold mb-4">3. Aplikasi Pencari Nilai Min/Max Manual</h2>
                <div class="flex gap-4 mb-2">
                    <input v-model="minMaxInput" type="text" class="border p-2 rounded w-full" placeholder="Masukkan angka pisahkan koma (contoh: 1, 3, 2, 9, 5)">
                    <select v-model="minMaxJenis" class="border p-2 rounded">
                        <option value="max">Cari Terbesar</option>
                        <option value="min">Cari Terkecil</option>
                    </select>
                </div>
                <button @click="hitungMinMax" class="bg-red-500 text-white px-4 py-2 rounded font-bold hover:bg-red-600 w-full">Cari Nilai</button>
                
                <div v-if="minMaxHasil" class="mt-4 p-3 bg-gray-100 rounded text-lg font-mono">Output Ekstrim: <span class="text-red-600 font-bold">{{ minMaxHasil }}</span></div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <h2 class="text-xl font-bold mb-4">4. Aplikasi Menghitung Umur & Tahun Kabisat</h2>
                <div class="flex gap-4">
                    <input v-model="umurInput" type="text" class="border p-2 rounded w-full" placeholder="Format: mm-dd-yyyy (contoh: 08-12-1990)">
                    <button @click="hitungUmur" class="bg-blue-500 text-white px-4 py-2 rounded font-bold hover:bg-blue-600">Hitung</button>
                </div>
                <div v-if="umurHasil" class="mt-4 p-3 bg-gray-100 rounded text-lg font-mono">
                    <p>Umur Saat Ini: <span class="text-blue-600 font-bold">{{ umurHasil }}</span></p>
                    <p>Kabisat Terlewati: <span class="text-blue-600 font-bold">{{ kabisatHasil }}</span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios'; // Wajib ada untuk tembak API

// State Fibonacci
const fiboInput = ref(5);
const fiboHasil = ref('');
const hitungFibo = async () => {
    const res = await axios.post(route('algoritma.fibo'), { input_angka: fiboInput.value });
    fiboHasil.value = res.data.output;
};

// State Sort
const sortInput = ref('3, 7, -3, 5, 9, 5');
const sortHasil = ref('');
const hitungSort = async () => {
    const res = await axios.post(route('algoritma.sort'), { input_array: sortInput.value });
    sortHasil.value = res.data.output;
};

// State MinMax
const minMaxInput = ref('1, 3, 2, 9, 5');
const minMaxJenis = ref('max');
const minMaxHasil = ref('');
const hitungMinMax = async () => {
    const res = await axios.post(route('algoritma.minmax'), { input_array: minMaxInput.value, jenis: minMaxJenis.value });
    minMaxHasil.value = res.data.output;
};

// State Hitung Umur
const umurInput = ref('08-12-1990');
const umurHasil = ref('');
const kabisatHasil = ref('');

const hitungUmur = async () => {
    const res = await axios.post(route('algoritma.umur'), { input_tanggal: umurInput.value });
    umurHasil.value = res.data.umur;
    kabisatHasil.value = res.data.kabisat;
};
</script>