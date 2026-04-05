<?php

// Session start for auth check
session_start();

// Props
$title = "VocaTIonal | Panduan";
$active = "panduan";

// Determine base paths
$publicDir = dirname(__FILE__); // /var/www/html/public
$appDir = dirname($publicDir) . '/app'; // /var/www/html/app

// Check login status using Auth class
require_once $appDir . '/Controllers/Auth.php';
$auth = new Auth();
$isLoggedIn = $auth->check();

// if Not LoggedIn, redirect to home page
if (!$isLoggedIn) {
    header('Location: ./');
    exit;
}

$user = $auth->user();

// Import header & navbar
include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';

?>

<main class="mx-auto px-6 md:px-16 py-8 md:py-16">
    <!-- Hero Section -->
    <section class="mb-16 md:mb-24">
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4 leading-tight">
                Panduan <span class="text-blue-900">VocaTIonal</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 max-w-2xl mx-auto">
                Semua yang perlu kamu tahu untuk menyuarakan aspirasi & berkontribusi dalam komunitas mahasiswa kami.
            </p>
        </div>
    </section>

    <!-- Navigation Tabs -->
    <div class="mb-12 flex flex-wrap gap-3 md:gap-4 border-b border-gray-200 pb-6">
        <button data-tab="cara-menggunakan" class="tab-button active px-6 py-3 font-semibold text-sm md:text-base text-blue-900 border-b-2 border-blue-900 transition-colors duration-200 flex items-center gap-2">
            <i data-lucide="book" class="w-4 h-4"></i>
            Cara Menggunakan
        </button>
        <button data-tab="faq" class="tab-button px-6 py-3 font-semibold text-sm md:text-base text-gray-600 hover:text-blue-900 border-b-2 border-transparent transition-colors duration-200 flex items-center gap-2">
            <i data-lucide="help-circle" class="w-4 h-4"></i>
            FAQ
        </button>
        <button data-tab="tips" class="tab-button px-6 py-3 font-semibold text-sm md:text-base text-gray-600 hover:text-blue-900 border-b-2 border-transparent transition-colors duration-200 flex items-center gap-2">
            <i data-lucide="lightbulb" class="w-4 h-4"></i>
            Tips & Trik
        </button>
        <button data-tab="kebijakan" class="tab-button px-6 py-3 font-semibold text-sm md:text-base text-gray-600 hover:text-blue-900 border-b-2 border-transparent transition-colors duration-200 flex items-center gap-2">
            <i data-lucide="file-text" class="w-4 h-4"></i>
            Kebijakan
        </button>
    </div>

    <!-- Tab Content -->
    <div class="space-y-8">
        <!-- Cara Menggunakan Tab -->
        <div id="cara-menggunakan" class="tab-content active">
            <div class="space-y-8">
                <!-- Step 1 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                <span class="text-2xl font-bold text-blue-900">1</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Login Menggunakan NPM</h3>
                            <p class="text-gray-600 mb-4">Kamu perlu login terlebih dahulu menggunakan NPM yang telah terdaftar. Setiap mahasiswa dari prodi Teknologi Informasi memiliki akses otomatis ke platform ini.</p>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-900">✓</span>
                                    Masukkan NPM di form login
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-900">✓</span>
                                    Jangan simpan password di browser untuk keamanan ekstra
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="text-blue-900">✓</span>
                                    Gunakan Incognito Mode jika login di komputer umum
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                <span class="text-2xl font-bold text-blue-900">2</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Tulis Aspirasi Kamu</h3>
                            <p class="text-gray-600 mb-4">Di halaman Beranda, kamu akan menemukan form untuk menulis aspirasi. Tuliskan aspirasi, keluhan, atau saran kamu dengan jelas dan santun.</p>
                            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                <p class="text-sm text-gray-700">
                                    <strong>Tip:</strong> Tuliskan aspirasi dengan detail agar tim advokasi bisa memahami dan merespon dengan lebih baik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                <span class="text-2xl font-bold text-blue-900">3</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Pilih Kategori</h3>
                            <p class="text-gray-600 mb-4">Pilih kategori yang paling sesuai dengan aspirasi kamu agar mudah dikelola oleh tim.</p>
                            <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">Akademik</p>
                                    <p class="text-xs text-gray-500 mt-1">Kurikulum, dosen, etc</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">Fasilitas</p>
                                    <p class="text-xs text-gray-500 mt-1">Ruangan, lab, etc</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">Sarpras</p>
                                    <p class="text-xs text-gray-500 mt-1">Proyektor, Komputer, etc</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">Layanan</p>
                                    <p class="text-xs text-gray-500 mt-1">Pengaduan, Sistem Informasi, etc</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">UKT</p>
                                    <p class="text-xs text-gray-500 mt-1">Biaya, kesulitan, etc</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-semibold text-gray-900">Lainnya</p>
                                    <p class="text-xs text-gray-500 mt-1">Yang lain</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                <span class="text-2xl font-bold text-blue-900">4</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Pilih Anonim (Opsional)</h3>
                            <p class="text-gray-600 mb-4">Kamu bisa memilih untuk mengirim aspirasi secara anonim jika merasa perlu untuk menjaga privasi. Informasi kamu tetap aman dan rahasia.</p>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm text-green-900">
                                    <strong>✓ Aspirasi anonim</strong> tetap diproses dengan serius dan ditangani oleh tim advokasi profesional
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                                <span class="text-2xl font-bold text-blue-900">5</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Monitor Status Aspirasi</h3>
                            <p class="text-gray-600 mb-4">Setelah submit, kamu bisa memantau status aspirasi di Papan Buletin. Status akan berubah dari "Pending" → "Proses" → "Selesai".</p>
                            <ul class="space-y-2 text-gray-600">
                                <li class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded text-xs font-semibold">Pending</span>
                                    Menunggu untuk diproses
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-900 rounded text-xs font-semibold">Proses</span>
                                    Sedang ditangani
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-green-100 text-green-900 rounded text-xs font-semibold">Selesai</span>
                                    Sudah mendapat respon
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Tab -->
        <div id="faq" class="tab-content hidden space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <button class="faq-button w-full px-6 md:px-8 py-5 text-left font-semibold text-gray-900 hover:bg-blue-50 transition-colors flex items-center justify-between" data-faq="faq-1">
                    <span>Apakah data saya aman di VocaTIonal?</span>
                    <span class="text-2xl text-blue-900 transition-transform duration-200">+</span>
                </button>
                <div id="faq-1" class="faq-content hidden px-6 md:px-8 pb-6 text-gray-600">
                    Ya, data kamu sangat aman. Sistem VocaTIonal menggunakan enkripsi tingkat enterprise untuk melindungi informasi pribadi. Hanya tim advokasi yang berwenang yang dapat mengakses data aspirasi kamu.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <button class="faq-button w-full px-6 md:px-8 py-5 text-left font-semibold text-gray-900 hover:bg-blue-50 transition-colors flex items-center justify-between" data-faq="faq-2">
                    <span>Berapa lama aspirasi saya akan mendapat respon?</span>
                    <span class="text-2xl text-blue-900 transition-transform duration-200">+</span>
                </button>
                <div id="faq-2" class="faq-content hidden px-6 md:px-8 pb-6 text-gray-600">
                    Biasanya aspirasi akan mendapat respon dalam 3-7 hari kerja. Namun waktu bisa berbeda tergantung kompleksitas aspirasi dan prioritas dari tim advokasi.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <button class="faq-button w-full px-6 md:px-8 py-5 text-left font-semibold text-gray-900 hover:bg-blue-50 transition-colors flex items-center justify-between" data-faq="faq-3">
                    <span>Bisa ganti atau hapus aspirasi yang sudah dikirim?</span>
                    <span class="text-2xl text-blue-900 transition-transform duration-200">+</span>
                </button>
                <div id="faq-3" class="faq-content hidden px-6 md:px-8 pb-6 text-gray-600">
                    Aspirasi yang sudah dikirim tidak bisa dihapus atau diubah, tapi kamu bisa mengirim aspirasi baru jika ada tambahan informasi atau koreksi yang diperlukan.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <button class="faq-button w-full px-6 md:px-8 py-5 text-left font-semibold text-gray-900 hover:bg-blue-50 transition-colors flex items-center justify-between" data-faq="faq-4">
                    <span>Apakah aspirasi anonim akan sama seriusnya dihandle?</span>
                    <span class="text-2xl text-blue-900 transition-transform duration-200">+</span>
                </button>
                <div id="faq-4" class="faq-content hidden px-6 md:px-8 pb-6 text-gray-600">
                    Tentu! Semua aspirasi, baik anonim maupun tidak, ditangani dengan serius dan profesional oleh tim advokasi. Kami tidak membedakan perlakuan berdasarkan anonimitas.
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <button class="faq-button w-full px-6 md:px-8 py-5 text-left font-semibold text-gray-900 hover:bg-blue-50 transition-colors flex items-center justify-between" data-faq="faq-5">
                    <span>Apa itu Papan Buletin?</span>
                    <span class="text-2xl text-blue-900 transition-transform duration-200">+</span>
                </button>
                <div id="faq-5" class="faq-content hidden px-6 md:px-8 pb-6 text-gray-600">
                    Papan Buletin adalah halaman yang menampilkan semua aspirasi dan tanggapannya yang dapat dilihat oleh semua mahasiswa. Di sini kamu bisa lihat perkembangan aspirasi dan belajar dari pengalaman mahasiswa lain.
                </div>
            </div>
        </div>

        <!-- Tips & Trik Tab -->
        <div id="tips" class="tab-content hidden space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tip 1 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="message-circle" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Tulis dengan Jelas</h3>
                    </div>
                    <p class="text-gray-600">
                        Jelaskan aspirasi kamu secara detail. Semakin jelas dan spesifik, semakin mudah tim advokasi memahami dan mencari solusinya. Hindari bahasa yang ambigu atau menyinggung.
                    </p>
                </div>

                <!-- Tip 2 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="target" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Pilih Kategori dengan Tepat</h3>
                    </div>
                    <p class="text-gray-600">
                        Memilih kategori yang tepat membantu aspirasi kamu sampai ke orang yang tepat. Jangan asal pilih kategori, pertimbangkan dengan matang.
                    </p>
                </div>

                <!-- Tip 3 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="bar-chart-2" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Pantau Perkembangan</h3>
                    </div>
                    <p class="text-gray-600">
                        Selalu cek Papan Buletin untuk melihat perkembangan aspirasi kamu. Kamu juga bisa memberikan feedback atau pertanyaan di bagian komentar.
                    </p>
                </div>

                <!-- Tip 4 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="heart" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Dukung Aspirasi Lain</h3>
                    </div>
                    <p class="text-gray-600">
                        Kamu bisa memberikan support atau react terhadap aspirasi mahasiswa lain. Ini membantu menunjukkan bahwa masalah tersebut penting bagi banyak orang.
                    </p>
                </div>

                <!-- Tip 5 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Jangan Spam</h3>
                    </div>
                    <p class="text-gray-600">
                        Hindari mengirim aspirasi duplikat atau spam. Gunakan fitur report untuk aspirasi yang tidak pantas, jangan send aspirasi balasan.
                    </p>
                </div>

                <!-- Tip 6 -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-3">
                        <i data-lucide="lock" class="w-6 h-6 text-blue-900"></i>
                        <h3 class="text-xl font-bold text-gray-900">Manfaatkan Anonim</h3>
                    </div>
                    <p class="text-gray-600">
                        Jika aspirasi kamu sensitif atau merasa takut, gunakan fitur anonim. Kami tetap akan menangani dengan serius dan profesional.
                    </p>
                </div>
            </div>
        </div>

        <!-- Kebijakan Tab -->
        <div id="kebijakan" class="tab-content hidden space-y-6">
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Panduan Komunitas</h3>
                <p class="text-gray-600 mb-4">
                    VocaTIonal adalah ruang aman untuk semua mahasiswa. Kami berkomitmen untuk menjaga lingkungan yang positif, inklusif, dan saling menghormati.
                </p>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">✓</span>
                        <span>Hormati pendapat dan aspirasi orang lain, bahkan jika berbeda dengan pendapat kamu</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">✓</span>
                        <span>Gunakan bahasa yang santun dan tidak menyinggung</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">✓</span>
                        <span>Jangan label atau bully seseorang di platform ini</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">✓</span>
                        <span>Fokus pada solusi, bukan pada menyalahkan orang tertentu</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Larangan</h3>
                <p class="text-gray-600 mb-4">
                    Aspirasi berikut akan dihapus dan penulis mungkin mendapat tindakan:
                </p>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Konten SARA (Suku, Agama, Ras, Antar-golongan)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Pornografi atau konten dewasa</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Ancaman atau intimidasi</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Spam atau duplikasi konten</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Iklan atau promosi komersial</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-red-500 font-bold mt-1">✗</span>
                        <span>Hoax atau informasi palsu</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Privasi & Keamanan</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">🔒</span>
                        <span>Data kamu dilindungi dengan enkripsi tingkat enterprise</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">🔒</span>
                        <span>Hanya tim advokasi yang dapat mengakses data pribadi</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">🔒</span>
                        <span>Aspirasi anonim benar-benar tersembunyi identitasnya</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-blue-900 font-bold mt-1">🔒</span>
                        <span>Jangan pernah bagikan password atau akun kamu ke orang lain</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="mt-20 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-8 md:p-16 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Siap untuk Menyuarakan Aspirasi?</h2>
        <p class="text-lg text-gray-600 mb-8 max-w-xl mx-auto">
            Jangan ragu untuk berbagi aspirasi, ide, atau keluhan kamu. Suara kamu penting dan akan kami dengarkan dengan serius.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="px-8 py-3 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition-colors flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-4 h-4"></i>
                Kirim Aspirasi
            </a>
            <a href="/bulletin-board.php" class="px-8 py-3 border-2 border-blue-900 text-blue-900 rounded-lg font-semibold hover:bg-blue-50 transition-colors flex items-center justify-center gap-2">
                <i data-lucide="eye" class="w-4 h-4"></i>
                Lihat Papan Buletin
            </a>
        </div>
    </section>
</main>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Tab Navigation
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.dataset.tab;
            
            // Remove active state from all buttons and contents
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-blue-900', 'text-blue-900');
                btn.classList.add('border-transparent', 'text-gray-600');
            });
            tabContents.forEach(content => content.classList.add('hidden'));

            // Add active state to clicked button and corresponding content
            button.classList.add('active', 'border-blue-900', 'text-blue-900');
            button.classList.remove('border-transparent', 'text-gray-600');
            document.getElementById(tabName).classList.remove('hidden');
            
            // Re-render icons after tab switch
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });

    // FAQ Toggle
    const faqButtons = document.querySelectorAll('.faq-button');

    faqButtons.forEach(button => {
        button.addEventListener('click', () => {
            const faqId = button.dataset.faq;
            const faqContent = document.getElementById(faqId);
            const isHidden = faqContent.classList.contains('hidden');

            // Close all other FAQs
            document.querySelectorAll('.faq-content').forEach(content => {
                content.classList.add('hidden');
                content.previousElementSibling.querySelector('span:last-child').textContent = '+';
            });

            // Toggle current FAQ
            if (isHidden) {
                faqContent.classList.remove('hidden');
                button.querySelector('span:last-child').textContent = '−';
            } else {
                faqContent.classList.add('hidden');
                button.querySelector('span:last-child').textContent = '+';
            }
        });
    });
</script>

</body>
</html>