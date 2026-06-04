<template>
    <Head title="Kelola Ujian" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-2xl text-gray-800 leading-tight">Kelola Data Ujian</h2></template>
        
        <div class="py-8"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 h-fit">
                <h3 class="font-bold text-lg border-b-2 border-red-100 pb-3 mb-5 flex items-center" :class="isEdit ? 'text-orange-600' : 'text-red-700'">
                    <span class="mr-2">📝</span> {{ isEdit ? 'Edit Data Ujian' : 'Buat Ujian Baru' }}
                </h3>
                
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold">Nama Ujian</label>
                        <input v-model="form.nama_ujian" type="text" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Mata Pelajaran</label>
                        <select v-model="form.id_matpel" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                            <option v-for="m in dataMatpel" :key="m.id_matpel" :value="m.id_matpel">{{ m.nama_matpel }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold">Tanggal</label>
                        <input v-model="form.tanggal" type="date" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                    </div>
                    
                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="w-full text-white font-bold py-3 rounded-lg transition" 
                            :class="isEdit ? 'bg-orange-500 hover:bg-orange-600' : 'bg-red-600 hover:bg-red-700'" :disabled="form.processing">
                            {{ isEdit ? 'Update Ujian' : 'Simpan Ujian' }}
                        </button>
                        <button v-if="isEdit" type="button" @click="batalEdit" class="bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-2">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 border-b-2"><tr><th class="py-3 px-4">Nama Ujian</th><th class="py-3 px-4">Matpel</th><th class="py-3 px-4">Tanggal</th><th class="py-3 px-4 text-center">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="ujian in dataUjian" :key="ujian.id_ujian" class="hover:bg-red-50 transition">
                            <td class="py-3 px-4 font-bold">{{ ujian.nama_ujian }}</td>
                            <td class="py-3 px-4">{{ ujian.nama_matpel }}</td>
                            <td class="py-3 px-4">{{ ujian.tanggal }}</td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <button @click="siapkanEdit(ujian)" class="bg-orange-100 text-orange-600 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-orange-600 hover:text-white">Edit</button>
                                <button @click="hapusUjian(ujian.id_ujian)" class="bg-red-100 text-red-600 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-red-600 hover:text-white">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div></div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({ dataUjian: Array, dataMatpel: Array });

const isEdit = ref(false);
const form = useForm({ id_ujian: '', nama_ujian: '', id_matpel: '', tanggal: '' });

const siapkanEdit = (ujian) => {
    isEdit.value = true;
    form.id_ujian = ujian.id_ujian;
    form.nama_ujian = ujian.nama_ujian;
    form.id_matpel = ujian.id_matpel;
    form.tanggal = ujian.tanggal;
};

const batalEdit = () => {
    isEdit.value = false;
    form.reset();
};

const submitForm = () => {
    if (isEdit.value) {
        form.put(route('ujian.update', form.id_ujian), { preserveScroll: true, onSuccess: () => batalEdit() });
    } else {
        form.post(route('ujian.store'), { preserveScroll: true, onSuccess: () => form.reset() });
    }
};

const hapusUjian = (id) => { if (confirm('Hapus ujian ini?')) router.delete(route('ujian.destroy', id), { preserveScroll: true }); };
</script>