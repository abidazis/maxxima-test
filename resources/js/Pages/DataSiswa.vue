<template>
    <Head title="Kelola Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Kelola Data Siswa</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 h-fit">
                    <h3 class="font-bold text-lg border-b-2 border-indigo-100 pb-3 mb-5 flex items-center" :class="isEdit ? 'text-orange-600' : 'text-indigo-700'">
                        <span class="mr-2">📝</span> {{ isEdit ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
                    </h3>
                    
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Siswa (NIS)</label>
                            <input v-model="form.nis" type="text" 
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm transition" 
                                :class="{'border-red-500': form.errors.nis, 'bg-gray-100 text-gray-500': isEdit}"
                                placeholder="Contoh: 10102023" :readonly="isEdit">
                            <div v-if="form.errors.nis" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.nis }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input v-model="form.nama" type="text" 
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm transition"
                                :class="{'border-red-500': form.errors.nama}"
                                placeholder="Masukkan nama lengkap">
                            <div v-if="form.errors.nama" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.nama }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili</label>
                            <textarea v-model="form.alamat" rows="3"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm transition"
                                :class="{'border-red-500': form.errors.alamat}"
                                placeholder="Masukkan alamat lengkap"></textarea>
                            <div v-if="form.errors.alamat" class="text-red-500 text-xs mt-1 font-medium">{{ form.errors.alamat }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" 
                                class="w-full text-white font-bold py-3 px-4 rounded-lg transition flex justify-center items-center" 
                                :disabled="form.processing"
                                :class="[
                                    isEdit ? 'bg-orange-500 hover:bg-orange-600' : 'bg-indigo-600 hover:bg-indigo-700',
                                    form.processing ? 'opacity-50 cursor-not-allowed' : ''
                                ]">
                                <span v-if="form.processing">Memproses...</span>
                                <span v-else>{{ isEdit ? 'Update Data' : 'Simpan Data' }}</span>
                            </button>

                            <button v-if="isEdit" type="button" @click="batalEdit"
                                class="bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 lg:col-span-2 overflow-hidden">
                    <h3 class="font-bold text-lg border-b-2 border-indigo-100 pb-3 mb-5 text-gray-800 flex items-center">
                        <span class="mr-2">📋</span> Daftar Siswa Terdaftar
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 font-semibold border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-3 px-4">NIS</th>
                                    <th class="py-3 px-4">Nama Lengkap</th>
                                    <th class="py-3 px-4">Alamat</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="siswa in dataSiswa" :key="siswa.nis" class="hover:bg-indigo-50 transition duration-150">
                                    <td class="py-3 px-4 font-mono text-indigo-600 font-semibold">{{ siswa.nis }}</td>
                                    <td class="py-3 px-4 font-bold text-gray-800">{{ siswa.nama }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ siswa.alamat }}</td>
                                    <td class="py-3 px-4 text-center space-x-2 whitespace-nowrap">
                                        <button @click="siapkanEdit(siswa)" class="bg-orange-100 text-orange-600 hover:bg-orange-600 hover:text-white px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm">
                                            Edit
                                        </button>
                                        <button @click="hapusSiswa(siswa.nis)" class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-md text-xs font-bold transition shadow-sm">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="dataSiswa.length === 0">
                                    <td colspan="4" class="py-12 text-center text-gray-400">Belum ada data siswa terdaftar.</td>
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
import { ref } from 'vue'; // WAJIB ADA UNTUK STATE EDIT

defineProps({ dataSiswa: Array });

// State untuk mendeteksi apakah sedang mode Edit
const isEdit = ref(false);

const form = useForm({
    nis: '',
    nama: '',
    alamat: ''
});

// Fungsi untuk melempar data dari tabel ke Form
const siapkanEdit = (siswa) => {
    isEdit.value = true;
    form.nis = siswa.nis;
    form.nama = siswa.nama;
    form.alamat = siswa.alamat;
    form.clearErrors(); // Hapus pesan error sebelumnya
};

// Fungsi batal Edit, kembalikan wujud form ke mode "Tambah Baru"
const batalEdit = () => {
    isEdit.value = false;
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    if (isEdit.value) {
        // MODE EDIT (Pakai method PUT)
        form.put(route('siswa.update', form.nis), {
            preserveScroll: true,
            onSuccess: () => {
                batalEdit(); // Jika berhasil, kembalikan ke wujud form tambah baru
            },
        });
    } else {
        // MODE TAMBAH BARU (Pakai method POST)
        form.post(route('siswa.store'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};

const hapusSiswa = (nis) => {
    if (confirm('Yakin ingin menghapus siswa ini?')) {
        router.delete(route('siswa.destroy', nis), { preserveScroll: true });
    }
};
</script>