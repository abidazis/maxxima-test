<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sistem Akademik Maxxima</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <Link :href="route('laporan.kelulusan')" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-indigo-50 border-l-4 border-indigo-500 transition">
                        <div class="p-6 text-gray-900 font-bold text-lg flex items-center justify-between">
                            <span>📊 Dashboard Laporan Kelulusan</span>
                            <span class="text-indigo-500">➔</span>
                        </div>
                    </Link>

                    <Link :href="route('siswa.index')" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-green-50 border-l-4 border-green-500 transition">
                        <div class="p-6 text-gray-900 font-bold text-lg flex items-center justify-between">
                            <span>👨‍🎓 Kelola Data Siswa</span>
                            <span class="text-green-500">➔</span>
                        </div>
                    </Link>

                    <Link :href="route('matpel.index')" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-yellow-50 border-l-4 border-yellow-500 transition">
                        <div class="p-6 text-gray-900 font-bold text-lg flex items-center justify-between">
                            <span>📚 Kelola Mata Pelajaran</span>
                            <span class="text-yellow-500">➔</span>
                        </div>
                    </Link>

                    <Link :href="route('ujian.index')" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-red-50 border-l-4 border-red-500 transition">
                        <div class="p-6 text-gray-900 font-bold text-lg flex items-center justify-between">
                            <span>📝 Kelola Data Ujian</span>
                            <span class="text-red-500">➔</span>
                        </div>
                    </Link>

                    <Link :href="route('peserta.index')" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-blue-50 border-l-4 border-blue-500 transition md:col-span-2">
                        <div class="p-6 text-gray-900 font-bold text-lg flex items-center justify-between">
                            <span>🎓 Kelola Peserta & Status Kelulusan</span>
                            <span class="text-blue-500">➔</span>
                        </div>
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>