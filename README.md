# 🎓 Sistem Akademik Maxxima - Technical Test

Sebuah platform Sistem Informasi Akademik berbasis **Single Page Application (SPA)** yang dikembangkan untuk menjawab *Technical Test* dari PT Maxxima. Sistem ini mengelola data master akademik, pendaftaran ujian, hingga laporan kelulusan secara *real-time* tanpa *reload* halaman, serta dilengkapi dengan modul penyelesaian algoritma dasar.

## 🚀 Teknologi yang Digunakan
Sistem ini dibangun menggunakan *stack* modern untuk memastikan performa yang cepat dan pengalaman pengguna (UX) yang optimal:
* **Backend:** Laravel 11 (PHP)
* **Frontend:** Vue.js 3 (Composition API)
* **Routing/Bridging:** Inertia.js (Menghubungkan Laravel & Vue tanpa membuat REST API manual)
* **Styling:** Tailwind CSS
* **Database:** MySQL
* **Authentication:** Laravel Breeze (Inertia/Vue)

## ✨ Fitur Utama (Sesuai Instruksi Test)

### 1. Manajemen Data Akademik (CRUD SPA)
Fitur Create, Read, Update, dan Delete yang mengimplementasikan konsep *Single Form Mutation* (Satu form dinamis untuk Tambah dan Edit) pada:
* 👨‍🎓 **Data Siswa:** Pengelolaan NIS (sebagai Primary Key bertipe String), Nama, dan Alamat.
* 📚 **Mata Pelajaran:** Pengelolaan data matpel.
* 📝 **Data Ujian:** Penjadwalan ujian beserta relasinya dengan Mata Pelajaran.
* 🎓 **Peserta & Kelulusan:** Pendaftaran siswa ke dalam ujian dan penentuan status kelulusan secara instan (*toggle status*).

### 2. Dashboard Laporan Terintegrasi (Complex Query Builder)
Melakukan *JOIN* pada 4 tabel relasional (Siswa, Mata Pelajaran, Ujian, Peserta) untuk menyajikan:
* Jadwal ujian terurut berdasarkan tanggal terbaru.
* Rekapitulasi ujian, total peserta, total lulus, dan persentase kelulusan.
* Kalkulasi otomatis total siswa yang lulus secara keseluruhan.
* Daftar siswa yang berstatus gagal beserta rincian mata pelajaran ujiannya.

### 3. Modul Mini-Apps Algoritma Dasar
Penyelesaian instruksi logika algoritma yang diisolasi dalam satu antarmuka interaktif:
* **Deret Fibonacci:** Penyelesaian menggunakan pendekatan *Fungsi Rekursif*.
* **Pengurutan (Sort):** Menggunakan logika *Bubble Sort* manual dengan *nested loop*.
* **Pencarian Nilai Ekstrim:** Pencarian nilai Maksimal/Minimal menggunakan algoritma *Linear Search*.
* **Kalkulator Umur & Kabisat:** Perhitungan umur presisi (Tahun, Bulan, Hari) menggunakan `DateTime`, dan perulangan `modulus` untuk deteksi Tahun Kabisat yang terlewati.

---

## 🛠️ Panduan Instalasi (Setup Project)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di mesin lokal:

1. **Clone Repository**
   ```bash
   git clone https://github.com/abidazis/maxxima-test.git