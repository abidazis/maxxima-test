<template>
    <Head title="Kelola Peserta & Ujian" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Pendaftaran Peserta & Status Kelulusan</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 h-fit">
                    <h3 class="font-bold text-lg border-b-2 border-blue-100 pb-3 mb-5 text-blue-700 flex items-center">
                        <span class="mr-2">🎓</span> Daftarkan Peserta
                    </h3>
                    
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Siswa</label>
                            <select v-model="form.nis" 
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                                :class="{'border-red-500': form.errors.nis}">
                                <option value="" disabled>-- Silakan Pilih Siswa --</option>
                                <option v-for="s in dataSiswa" :key="s.nis" :value="s.nis">{{ s.nis }} - {{ s.nama }}</option>
                            </select>
                            <div v-if="form.errors.nis" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.nis }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Ujian</label>
                            <select v-model="form.id_ujian" 
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                                <option value="" disabled>-- Silakan Pilih Ujian --</option>
                                
                                <option v-for="u in dataUjian" :key="u.id_ujian" :value="u.id_ujian">
                                    {{ u.nama_ujian }} - ({{ u.nama_matpel }})
                                </option>
                                
                            </select>
                        </div>

                        <button type="submit" 
                            class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition flex justify-center items-center"
                            :disabled="form.processing"
                            :class="{ 'opacity-50 cursor-not-allowed': form.processing }">
                            <span v-if="form.processing">Mendaftarkan...</span>
                            <span v-else>Daftarkan Sekarang</span>
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 lg:col-span-2 overflow-hidden">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b-2 border-blue-100 pb-3 mb-5 gap-4">
                        <h3 class="font-bold text-lg text-gray-800 flex items-center">
                            <span class="mr-2">🏆</span> Manajemen Kelulusan Peserta
                        </h3>
                        
                        <div class="flex items-center w-full md:w-auto bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                            <span class="text-sm font-bold text-blue-800 mr-3 whitespace-nowrap">Filter Ujian:</span>
                            <select v-model="filterUjian" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm w-full md:w-64 py-1.5">
                                <option value="">Tampilkan Semua Data</option>
                                <option v-for="u in dataUjian" :key="u.id_ujian" :value="u.id_ujian">
                                    {{ u.nama_ujian }} - ({{ u.nama_matpel }})
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 font-semibold border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-3 px-4">Nama Siswa</th>
                                    <th class="py-3 px-4">Ujian Diikuti</th>
                                    <th class="py-3 px-4 text-center">Status Saat Ini</th>
                                    <th class="py-3 px-4 text-center">Aksi & Eksekusi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="p in filteredPeserta" :key="p.id" class="hover:bg-blue-50 transition duration-150">
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ p.nama }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ p.nama_ujian }}</td>
                                    
                                    <td class="py-3 px-4 text-center">
                                        <span v-if="p.status_lulus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                            ✅ LULUS
                                        </span>
                                        <span v-else class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                            ❌ GAGAL
                                        </span>
                                    </td>
                                    
                                    <td class="py-3 px-4 text-center flex justify-center space-x-2">
                                        <button @click="ubahStatus(p.id, p.status_lulus)" 
                                            class="px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm text-white"
                                            :class="p.status_lulus ? 'bg-orange-400 hover:bg-orange-500' : 'bg-green-500 hover:bg-green-600'">
                                            {{ p.status_lulus ? 'Batalkan Kelulusan' : 'Luluskan Siswa' }}
                                        </button>
                                        
                                        <button @click="hapusPeserta(p.id)" class="bg-gray-200 text-gray-600 hover:bg-gray-300 px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                
                                <tr v-if="filteredPeserta.length === 0">
                                    <td colspan="4" class="py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <span class="text-4xl mb-2">📭</span>
                                            <p>Data peserta tidak ditemukan pada filter ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // WAJIB DITAMBAHKAN

const props = defineProps({ dataPeserta: Array, dataSiswa: Array, dataUjian: Array }); // Ubah defineProps menjadi variabel props

// FITUR FILTER: Variabel reaktif untuk menampung pilihan dropdown
const filterUjian = ref('');

// FITUR FILTER: Logika komputasi penyaringan data
const filteredPeserta = computed(() => {
    if (!filterUjian.value) {
        return props.dataPeserta; // Tampilkan semua jika dropdown "Tampilkan Semua Data"
    }
    // Saring data berdasarkan id_ujian yang dipilih
    return props.dataPeserta.filter(p => p.id_ujian === filterUjian.value);
});

const form = useForm({
    nis: '',
    id_ujian: ''
});

const submitForm = () => {
    form.post(route('peserta.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const hapusPeserta = (id) => {
    if (confirm('Yakin ingin membatalkan peserta ini dari ujian?')) {
        router.delete(route('peserta.destroy', id), { preserveScroll: true });
    }
};

const ubahStatus = (id, currentStatus) => {
    router.put(route('peserta.update', id), { status_lulus: !currentStatus }, { preserveScroll: true });
};
</script>