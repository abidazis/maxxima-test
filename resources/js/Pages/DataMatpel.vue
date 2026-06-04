<template>
    <Head title="Kelola Matpel" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-2xl text-gray-800 leading-tight">Kelola Mata Pelajaran</h2></template>
        
        <div class="py-8"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-1 h-fit">
                <h3 class="font-bold text-lg border-b-2 border-yellow-100 pb-3 mb-5 flex items-center" :class="isEdit ? 'text-orange-600' : 'text-yellow-600'">
                    <span class="mr-2">📚</span> {{ isEdit ? 'Edit Mata Pelajaran' : 'Tambah Matpel' }}
                </h3>
                
                <form @submit.prevent="submitForm" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Mata Pelajaran</label>
                        <input v-model="form.nama_matpel" type="text" class="w-full border-gray-300 focus:border-yellow-500 rounded-lg shadow-sm" required>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="w-full text-white font-bold py-3 rounded-lg hover:bg-opacity-90 transition" 
                            :class="isEdit ? 'bg-orange-500' : 'bg-yellow-500'" :disabled="form.processing">
                            {{ isEdit ? 'Update Matpel' : 'Simpan Matpel' }}
                        </button>
                        <button v-if="isEdit" type="button" @click="batalEdit" class="bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 col-span-2">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 border-b-2"><tr><th class="py-3 px-4">ID</th><th class="py-3 px-4">Mata Pelajaran</th><th class="py-3 px-4 text-center">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="matpel in dataMatpel" :key="matpel.id_matpel" class="hover:bg-yellow-50 transition">
                            <td class="py-3 px-4 font-mono">{{ matpel.id_matpel }}</td>
                            <td class="py-3 px-4 font-bold">{{ matpel.nama_matpel }}</td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <button @click="siapkanEdit(matpel)" class="bg-orange-100 text-orange-600 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-orange-600 hover:text-white">Edit</button>
                                <button @click="hapusMatpel(matpel.id_matpel)" class="bg-red-100 text-red-600 px-3 py-1.5 rounded-md text-xs font-bold hover:bg-red-600 hover:text-white">Hapus</button>
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

defineProps({ dataMatpel: Array });

const isEdit = ref(false);
const form = useForm({ id_matpel: '', nama_matpel: '' });

const siapkanEdit = (matpel) => {
    isEdit.value = true;
    form.id_matpel = matpel.id_matpel;
    form.nama_matpel = matpel.nama_matpel;
};

const batalEdit = () => {
    isEdit.value = false;
    form.reset();
};

const submitForm = () => {
    if (isEdit.value) {
        form.put(route('matpel.update', form.id_matpel), { preserveScroll: true, onSuccess: () => batalEdit() });
    } else {
        form.post(route('matpel.store'), { preserveScroll: true, onSuccess: () => form.reset() });
    }
};

const hapusMatpel = (id) => { if (confirm('Hapus matpel ini?')) router.delete(route('matpel.destroy', id), { preserveScroll: true }); };
</script>