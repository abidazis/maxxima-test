<template>
    <Head title="Kelola Matpel" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Mata Pelajaran</h2></template>
        <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md col-span-1 h-fit">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">Tambah Matpel</h3>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Matpel</label>
                        <input v-model="form.nama_matpel" type="text" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600">Simpan</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-800 text-white"><tr><th class="py-2 px-4 text-left">ID</th><th class="py-2 px-4 text-left">Mata Pelajaran</th><th class="py-2 px-4 text-center">Aksi</th></tr></thead>
                    <tbody>
                        <tr v-for="matpel in dataMatpel" :key="matpel.id_matpel" class="border-b">
                            <td class="py-2 px-4">{{ matpel.id_matpel }}</td>
                            <td class="py-2 px-4 font-bold">{{ matpel.nama_matpel }}</td>
                            <td class="py-2 px-4 text-center"><button @click="hapusMatpel(matpel.id_matpel)" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-700">Hapus</button></td>
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
defineProps({ dataMatpel: Array });
const form = useForm({ nama_matpel: '' });
const submitForm = () => { form.post(route('matpel.store'), { onSuccess: () => form.reset() }); };
const hapusMatpel = (id) => { if (confirm('Hapus?')) router.delete(route('matpel.destroy', id)); };
</script>