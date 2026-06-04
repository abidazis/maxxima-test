<template>
    <Head title="Kelola Ujian" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Ujian</h2></template>
        <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-md col-span-1 h-fit">
                <h3 class="font-bold text-lg border-b pb-2 mb-4">Buat Ujian Baru</h3>
                <form @submit.prevent="submitForm">
                    <div class="mb-4"><label class="block text-sm">Nama Ujian</label><input v-model="form.nama_ujian" type="text" class="w-full border-gray-300 rounded" required></div>
                    <div class="mb-4">
                        <label class="block text-sm">Mata Pelajaran</label>
                        <select v-model="form.id_matpel" class="w-full border-gray-300 rounded" required>
                            <option v-for="m in dataMatpel" :key="m.id_matpel" :value="m.id_matpel">{{ m.nama_matpel }}</option>
                        </select>
                    </div>
                    <div class="mb-4"><label class="block text-sm">Tanggal</label><input v-model="form.tanggal" type="date" class="w-full border-gray-300 rounded" required></div>
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 font-bold">Simpan</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-800 text-white"><tr><th>Nama Ujian</th><th>Matpel</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                    <tbody class="text-center">
                        <tr v-for="ujian in dataUjian" :key="ujian.id_ujian" class="border-b">
                            <td>{{ ujian.nama_ujian }}</td><td>{{ ujian.nama_matpel }}</td><td>{{ ujian.tanggal }}</td>
                            <td><button @click="hapusUjian(ujian.id_ujian)" class="bg-red-500 text-white px-3 py-1 rounded text-xs">Hapus</button></td>
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
defineProps({ dataUjian: Array, dataMatpel: Array });
const form = useForm({ nama_ujian: '', id_matpel: '', tanggal: '' });
const submitForm = () => { form.post(route('ujian.store'), { onSuccess: () => form.reset() }); };
const hapusUjian = (id) => { if (confirm('Hapus?')) router.delete(route('ujian.destroy', id)); };
</script>