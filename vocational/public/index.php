<?php 
// SUPPRESS ERRORS DI PRODUCTION - PREVENT HTML WARNINGS MIXED WITH JSON
ini_set('display_errors', '0');
error_reporting(E_ALL);

// ============================================
// SECURITY: Add essential security headers
// ============================================
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

// START SESSION SEBELUM OUTPUT APAPUN (PENTING!)
session_start();

// Generate CSRF token if not exists (needed for login form)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 1. Definisikan Props
$title = "VocaTIonal | Aspirasi Mahasiswa";
$active = "beranda";

// Check login status early
require_once __DIR__ . '/../app/Controllers/Auth.php';
$auth = new Auth();
$isLoggedIn = $auth->check();
$user = $isLoggedIn ? $auth->user() : null;

// 2. Import Header & Navbar
include __DIR__ . '/../app/Views/Components/Header.php';
include __DIR__ . '/../app/Views/Components/Navbar.php';
?>
    <main id="main-content" class="mx-auto px-4 md:px-8 py-8 md:py-16 max-w-7xl">
        <header class="mb-8 md:mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                Halo, Mahasiswa <span class="text-blue-900">Teknologi Informasi!</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600">Ada aspirasi atau keluhan? Suarakan di bawah ini.</p>
        </header>

        <!-- Skeleton Loader -->
        <div id="skeleton-loader" aria-hidden="true" class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-pulse">
            <div class="lg:col-span-2 glass-card p-6 md:p-10 shadow-sm border-none bg-gray-200/50">
                <div class="h-4 bg-gray-300 rounded-full w-48 mb-6"></div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
                <div class="flex flex-col xl:flex-row gap-3">
                    <div class="flex-1 space-y-6">
                        <div class="h-14 bg-gray-300 rounded-xl"></div>
                        <div class="h-48 bg-gray-300 rounded-xl"></div>
                    </div>
                    <div class="flex-1 h-[200px] bg-gray-300 rounded-2xl"></div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="h-40 bg-gray-300 rounded-2xl"></div>
                <div class="h-64 bg-gray-300 rounded-2xl"></div>
            </div>
        </div>

        <!-- Main Content (aspiration form) -->
        <?php if ($isLoggedIn) : ?>
        <div id="aspiration-content" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
            <section class="lg:col-span-2 glass-card p-6 md:p-10 shadow-sm" aria-labelledby="form-heading">
                <h2 id="form-heading" class="sr-only">Form Aspirasi</h2>
                <form id="submissionForm" aria-label="Form kirim aspirasi">
                    <input type="hidden" name="csrf_token" id="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    
                    <fieldset class="border-none p-0 m-0 mb-6">
                        <legend class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4">Pilih Kategori Laporan</legend>
                        <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 md:gap-4" role="radiogroup" aria-label="Kategori aspirasi">
                            <button type="button" class="btn-category active py-3 md:py-4 font-semibold text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="true">Akademik</button>
                            <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-700 hover:bg-gray-50 text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="false">Fasilitas</button>
                            <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-700 hover:bg-gray-50 text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="false">Sarpras</button>
                            <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-700 hover:bg-gray-50 text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="false">Layanan</button>
                            <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-700 hover:bg-gray-50 text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="false">UKT</button>
                            <button type="button" class="btn-category py-3 md:py-4 font-semibold text-gray-700 hover:bg-gray-50 text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2" role="radio" aria-checked="false">Lainnya</button>
                        </div>
                    </fieldset>

                    <div class="space-y-4">
                        <div>
                            <label for="aspirasi-subjek" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Subjek</label>
                            <input id="aspirasi-subjek" type="text" placeholder="Subjek Laporan..." maxlength="100"
                                class="w-full bg-gray-50 border border-gray-500 rounded-xl px-4 py-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                                aria-required="true">
                        </div>

                        <div class="flex flex-col xl:flex-row gap-4">
                            <div class="flex-1 relative">
                                <label for="aspirasi-detail" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Detail Laporan</label>
                                <textarea id="aspirasi-detail" rows="6" placeholder="Detail Laporan..." maxlength="500"
                                    class="w-full h-48 bg-gray-50 border border-gray-500 rounded-xl px-4 py-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                                    aria-required="true"
                                    aria-describedby="char-counter"></textarea>
                                <span id="char-counter" class="absolute bottom-4 right-4 text-xs text-gray-600" aria-live="polite"><span id="char-count">0</span>/500 Karakter</span>
                            </div>
                            
                            <div class="flex-1">
                                <label for="bukti_foto" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Bukti Foto (Opsional)</label>
                                <div class="border-2 border-dashed border-gray-500 rounded-2xl flex flex-col items-center justify-center p-8 hover:bg-gray-50 transition-all min-h-[200px] relative overflow-hidden text-center">
                                    <input type="file" id="bukti_foto" name="bukti_foto" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" aria-describedby="upload-hint">
                                    <div id="upload-placeholder" class="flex flex-col items-center pointer-events-none">
                                        <i data-lucide="camera" aria-hidden="true" class="text-gray-600 w-10 h-10 mb-4"></i>
                                        <p id="upload-hint" class="font-bold text-gray-600">Upload Bukti (maks 5MB)</p>
                                    </div>
                                    <div id="preview-container" class="hidden absolute inset-0 bg-white flex items-center justify-center p-2">
                                        <img id="image-preview" src="#" alt="Preview bukti foto" class="max-h-full max-w-full rounded-xl object-contain">
                                        <button type="button" id="remove-img" aria-label="Hapus foto" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-lg z-20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                                            <i data-lucide="x" aria-hidden="true" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 pt-6">
                            <div class="flex flex-col sm:flex-row gap-4 self-start">
                                <div class="flex items-center cursor-pointer group" role="switch" aria-checked="false" aria-label="Kirim sebagai anonim" tabindex="0" id="anonim-switch">
                                    <div class="relative">
                                        <input type="checkbox" id="anonim-checkbox" class="sr-only" aria-hidden="true">
                                        <div class="block bg-gray-300 w-12 h-7 md:w-14 md:h-8 rounded-full transition"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-5 h-5 md:w-6 md:h-6 rounded-full transition shadow-sm"></div>
                                    </div>
                                    <span class="ml-3 text-gray-700 font-semibold text-sm md:text-base">Kirim Anonim</span>
                                </div>
                                <?php include __DIR__ . '/../app/Views/Components/ShowBoardToggle.php'; ?>
                            </div>

                            <button id="btn-show-confirm" type="button" 
                                    class="w-full sm:w-auto bg-[#111827] text-white px-10 py-4 rounded-xl font-medium uppercase tracking-widest hover:bg-black transition-all text-sm md:text-base focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
                                Kirim Aspirasi
                            </button>
                        </div>
                    </div>
                </form>
            </section>


            <!-- Sidebar -->
            <aside class="w-full space-y-6" aria-label="Informasi tambahan">
                <section class="info-card p-6 md:p-8 shadow-lg" aria-labelledby="system-status-heading">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse" aria-hidden="true"></div>
                        <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-white" id="system-status-heading">System Operational</span>
                    </div>
                    <h3 class="text-base md:text-lg font-bold mb-2 text-white">Network Transparency</h3>
                    <p class="text-xs md:text-sm text-blue-100 leading-relaxed">
                        Layanan aspirasi berjalan di atas protokol enkripsi satu arah. Data Anda aman dan anonim.
                    </p>
                </section>

                <section class="bg-gray-100 border border-gray-200 rounded-2xl p-6 md:p-8" aria-labelledby="guide-heading">
                    <h3 id="guide-heading" class="text-xs md:text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Panduan Anonimitas</h3>
                    <ol class="space-y-4 list-none">
                        <li class="flex gap-3">
                            <span class="font-bold text-blue-900 text-sm flex-shrink-0" aria-hidden="true">01</span>
                            <p class="text-xs md:text-sm text-gray-700 font-medium leading-relaxed">
                                <strong>Bersihkan Identitas:</strong> Hindari menyebutkan nama atau NIM dalam subjek dan detail laporan.
                            </p>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-blue-900 text-sm flex-shrink-0" aria-hidden="true">02</span>
                            <p class="text-xs md:text-sm text-gray-700 font-medium leading-relaxed">
                                <strong>Sensor Bukti:</strong> Pastikan foto bukti tidak mengandung informasi pribadi yang tidak relevan.
                            </p>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-blue-900 text-sm flex-shrink-0" aria-hidden="true">03</span>
                            <p class="text-xs md:text-sm text-gray-700 font-medium leading-relaxed">
                                <strong>Metadata Strip:</strong> Sistem otomatis menghapus data lokasi (EXIF) pada setiap gambar yang diunggah.
                            </p>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-blue-900 text-sm flex-shrink-0" aria-hidden="true">04</span>
                            <p class="text-xs md:text-sm text-gray-700 font-medium leading-relaxed">
                                <strong>Session Purge:</strong> Tutup browser setelah melapor untuk menghapus jejak sesi pada perangkat.
                            </p>
                        </li>
                    </ol>
                </section>
            </aside>
        </div>
        <?php endif; ?>
    </main>

    <input type="hidden" name="kategori" id="selected-category" value="Akademik">


    <script>
        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        function sanitizeHTML(text) {
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function validateNPM(npm) {
            return /^\d{10}$/.test(npm.replace(/\./g, ''));
        }

        function validateFile(file) {
            const maxSize = 5 * 1024 * 1024;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!file) return { valid: true, message: '' };
            if (!allowedTypes.includes(file.type)) return { valid: false, message: 'Hanya file gambar (JPEG, PNG, GIF, WebP) yang diperbolehkan' };
            if (file.size > maxSize) return { valid: false, message: 'Ukuran file maksimal 5MB' };
            return { valid: true, message: '' };
        }

        function getCSRFToken() {
            return document.getElementById('csrf-token')?.value || '';
        }

        // ============================================
        // SKELETON TO CONTENT TRANSITION
        // ============================================
        const isLoggedInUser = <?= $isLoggedIn ? 'true' : 'false' ?>;
        
        window.addEventListener('DOMContentLoaded', () => {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('aspiration-content');

            if (isLoggedInUser) {
                setTimeout(() => {
                    skeleton.classList.add('fade-out');
                    setTimeout(() => {
                        skeleton.style.display = 'none';
                        content.classList.remove('hidden');
                        setTimeout(() => {
                            content.classList.add('fade-in');
                            lucide.createIcons();
                        }, 50);
                    }, 500);
                }, 1500);
            }
        });
        
        function handleLoginSuccess() {
            setTimeout(() => { window.location.href = window.location.href; }, 1000);
        }
        
        // ============================================
        // CATEGORY SELECTION (aria-checked)
        // ============================================
        const categoryButtons = document.querySelectorAll('.btn-category');
        const categoryInput = document.getElementById('selected-category');

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                categoryButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-white', 'bg-blue-900');
                    btn.classList.add('text-gray-700', 'hover:bg-gray-50');
                    btn.setAttribute('aria-checked', 'false');
                });
                button.classList.add('active', 'text-white', 'bg-blue-900');
                button.classList.remove('text-gray-700', 'hover:bg-gray-50');
                button.setAttribute('aria-checked', 'true');
                categoryInput.value = button.innerText;
            });
        });

        // ============================================
        // ANONIM SWITCH (role=switch with keyboard)
        // ============================================
        const anonimSwitch = document.getElementById('anonim-switch');
        const anonimCheckbox = document.getElementById('anonim-checkbox');
        if (anonimSwitch && anonimCheckbox) {
            function toggleAnonim() {
                const isChecked = anonimCheckbox.checked;
                anonimCheckbox.checked = !isChecked;
                anonimSwitch.setAttribute('aria-checked', String(!isChecked));
            }
            anonimSwitch.addEventListener('click', toggleAnonim);
            anonimSwitch.addEventListener('keydown', function(e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    toggleAnonim();
                }
            });
        }

        // ============================================
        // IMAGE PREVIEW
        // ============================================
        const fileInput = document.getElementById('bukti_foto');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        const removeBtn = document.getElementById('remove-img');

        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const validation = validateFile(file);
                    if (!validation.valid) { alert(validation.message); this.value = ''; return; }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                fileInput.value = "";
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
            });
        }

        // Character counter
        const detailTextarea = document.getElementById('aspirasi-detail');
        const charCount = document.getElementById('char-count');
        if (detailTextarea && charCount) {
            detailTextarea.addEventListener('input', function() { charCount.textContent = this.value.length; });
        }

        lucide.createIcons();
    </script>


    <?php if ($isLoggedIn) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('aspiration-content');
            skeleton.style.display = 'none';
            content.classList.remove('hidden');
            content.classList.add('fade-in');
            if (typeof lucide !== 'undefined') lucide.createIcons();
            
            const remainingTime = <?= $user['remaining_time'] ?> * 1000;
            const warningThreshold = 5 * 60 * 1000;
            
            if (remainingTime <= warningThreshold && remainingTime > 0) {
                const minutes = Math.floor(remainingTime / 60000);
                setTimeout(() => {
                    window.confirmationModal.open({
                        title: 'Peringatan: Session Akan Berakhir',
                        message: `Session Anda akan berakhir dalam ${minutes} menit.`,
                        confirmText: 'Perpanjang Session',
                        cancelText: 'OK',
                        confirmBtnColor: 'orange',
                        onConfirm: async () => { window.location.href = window.location.href; }
                    });
                }, 500);
            }
            
            if (remainingTime > 0) {
                setTimeout(() => {
                    window.confirmationModal.open({
                        title: 'Session Telah Berakhir',
                        message: 'Session Anda telah kadaluarsa. Silakan login kembali.',
                        confirmText: 'Login Kembali',
                        cancelText: 'Logout',
                        confirmBtnColor: 'blue',
                        onConfirm: async () => { window.location.href = window.location.href; },
                        onCancel: async () => { window.location.href = './api/logout.php'; }
                    });
                }, remainingTime + 1000);
            }
        });
    </script>
    <?php else : ?>

    <!-- Login Modal Overlay -->
    <div id="login-modal" role="dialog" aria-modal="true" aria-labelledby="login-heading" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-950/40 backdrop-blur-md">
        <div class="w-[95%] max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Column A: Login Form -->
            <div class="lg:col-span-5 p-10 md:p-12 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-8">
                    <img src="./assets/img/logo-himatif.svg" alt="" aria-hidden="true" class="w-10 h-10 object-contain">
                    <span class="text-lg font-bold text-gray-900">VocaTIonal</span>
                </div>

                <h2 id="login-heading" class="text-xl font-bold text-gray-900 mb-1">Masuk ke Akun</h2>
                <p class="text-sm text-gray-600 mb-8">Gunakan NPM dan password untuk melanjutkan.</p>

                <form id="login-form" novalidate>
                    <input type="hidden" name="csrf_token" id="login-csrf-token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <div class="mb-5">
                        <label for="npm-input" class="block text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-1.5">NPM</label>
                        <input type="text" id="npm-input" name="npm" placeholder="XX.X.XX.XX.XXX" maxlength="14"
                            class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3.5 text-sm font-medium tracking-widest text-gray-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                            autocomplete="username" aria-required="true" required>
                    </div>

                    <div class="mb-5">
                        <label for="password-input" class="block text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="password-input" name="password" placeholder="Masukkan password"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3.5 pr-10 text-sm font-medium text-gray-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                                autocomplete="current-password" aria-required="true" required>
                            <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1 rounded" data-target="password-input" aria-label="Tampilkan password">
                                <i data-lucide="eye" class="w-4 h-4 pointer-events-none"></i>
                            </button>
                        </div>
                    </div>

                    <div id="login-error" role="alert" aria-live="assertive" class="text-xs text-red-600 mb-4 hidden font-medium"></div>

                    <button id="btn-login" type="submit"
                            class="w-full bg-[#111827] text-white rounded-lg px-4 py-3.5 font-medium text-sm hover:bg-black transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
                        Masuk
                    </button>
                </form>

                <p class="text-[11px] text-gray-500 mt-8">Data dienkripsi secara end-to-end.</p>
            </div>

            <!-- Column B: Quick Guide Hub -->
            <div class="lg:col-span-7 bg-slate-50 p-10 md:p-12 border-t lg:border-t-0 lg:border-l border-gray-100">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-6">Panduan Cepat</h3>

                <!-- First Login Notice -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i data-lucide="key-round" aria-hidden="true" class="w-5 h-5 text-blue-900 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 mb-1">Akses Pertama Kamu?</p>
                            <p class="text-xs text-gray-700 leading-relaxed">Password default adalah <strong>10 digit NPM</strong> kamu (tanpa titik). Kamu bisa mengubahnya di halaman Pengaturan setelah login.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="mb-6">
                    <p class="text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-3">FAQ Singkat</p>
                    <div class="space-y-2">
                        <details class="group bg-white border border-gray-200 rounded-lg">
                            <summary class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1 rounded-lg">
                                Apakah data saya aman?
                                <i data-lucide="chevron-down" aria-hidden="true" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="px-4 pb-3 text-xs text-gray-600 leading-relaxed">Ya. Semua data dienkripsi dan aspirasi anonim tidak dapat dilacak ke identitas pengirim. Sistem menggunakan session terenkripsi dengan timeout 60 menit.</p>
                        </details>
                        <details class="group bg-white border border-gray-200 rounded-lg">
                            <summary class="flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1 rounded-lg">
                                NPM saya belum terdaftar?
                                <i data-lucide="chevron-down" aria-hidden="true" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="px-4 pb-3 text-xs text-gray-600 leading-relaxed">Hubungi pengurus HIMATIF atau admin sistem untuk mendaftarkan NPM kamu ke dalam whitelist. Hanya mahasiswa TI aktif yang dapat mengakses platform.</p>
                        </details>
                    </div>
                </div>

                <!-- Community Policy -->
                <div>
                    <p class="text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-3">Kebijakan Komunitas</p>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" aria-hidden="true" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span class="text-xs text-gray-700">Sampaikan aspirasi dengan bahasa yang sopan dan konstruktif.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" aria-hidden="true" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span class="text-xs text-gray-700">Jangan sertakan data pribadi orang lain tanpa izin.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" aria-hidden="true" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span class="text-xs text-gray-700">Aspirasi yang melanggar akan ditinjau dan dapat dihapus oleh admin.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>


    <script>
        // ============================================
        // LOGIN FORM
        // ============================================
        const npmInput = document.getElementById('npm-input');
        if (npmInput) {
            npmInput.addEventListener('input', function() {
                let numbers = this.value.replace(/[^0-9]/g, '');
                let formatted = '';
                if (numbers.length > 0) formatted += numbers.substring(0, 2);
                if (numbers.length > 2) formatted += '.' + numbers.substring(2, 3);
                if (numbers.length > 3) formatted += '.' + numbers.substring(3, 5);
                if (numbers.length > 5) formatted += '.' + numbers.substring(5, 7);
                if (numbers.length > 7) formatted += '.' + numbers.substring(7, 10);
                this.value = formatted;
            });
        }

        // ============================================
        // TOGGLE PASSWORD VISIBILITY
        // ============================================
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye');
                }
                lucide.createIcons();
            });
        });

        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const errorEl = document.getElementById('login-error');
                const btn = document.getElementById('btn-login');
                const npm = npmInput.value.replace(/\./g, '');
                const password = document.getElementById('password-input').value;
                const csrfToken = document.getElementById('login-csrf-token')?.value;

                // Clear previous errors
                errorEl.classList.add('hidden');
                errorEl.textContent = '';

                if (!validateNPM(npmInput.value)) {
                    errorEl.textContent = 'NPM harus 10 digit angka. Format: XX.X.XX.XX.XXX';
                    errorEl.classList.remove('hidden');
                    npmInput.focus();
                    return;
                }
                if (!password) {
                    errorEl.textContent = 'Password harus diisi';
                    errorEl.classList.remove('hidden');
                    document.getElementById('password-input').focus();
                    return;
                }
                if (!csrfToken) {
                    errorEl.textContent = 'Security Error: CSRF token tidak ditemukan. Refresh halaman.';
                    errorEl.classList.remove('hidden');
                    return;
                }

                const originalText = btn.innerText;
                btn.innerText = 'Memproses...';
                btn.disabled = true;

                try {
                    const response = await fetch('./api/login.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: JSON.stringify({ npm, password, csrf_token: csrfToken })
                    });
                    const responseText = await response.text();
                    try {
                        const result = JSON.parse(responseText);
                        if (result.success) {
                            btn.innerText = 'Mengalihkan...';
                            setTimeout(() => { window.location.href = window.location.href; }, 1000);
                        } else {
                            errorEl.textContent = result.message || 'Login gagal';
                            errorEl.classList.remove('hidden');
                            npmInput.focus();
                            btn.innerText = originalText;
                            btn.disabled = false;
                        }
                    } catch (jsonError) {
                        if (response.ok) {
                            btn.innerText = 'Mengalihkan...';
                            setTimeout(() => { window.location.href = window.location.href; }, 1000);
                        } else {
                            errorEl.textContent = 'Terjadi kesalahan saat login. Silakan coba lagi.';
                            errorEl.classList.remove('hidden');
                            btn.innerText = originalText;
                            btn.disabled = false;
                        }
                    }
                } catch (error) {
                    errorEl.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    errorEl.classList.remove('hidden');
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            });
        }
    </script>

    <?php 
        include __DIR__ . '/../app/Views/Components/ConfirmationModal.php';
        include __DIR__ . '/../app/Views/Components/Form-ConfirmationAspirasi.php';
    ?>

    <script src="./js/toast.js"></script>
    <script src="./js/confirmation-modal.js"></script>

    <script>
        // ==========================================
        // ASPIRATION SUBMISSION MODAL
        // ==========================================
        const modal = document.getElementById('modal-confirm');
        const modalBox = document.getElementById('modal-box');
        const btnKirimAspirasi = document.getElementById('btn-show-confirm');
        const showBoardCheckbox = document.querySelector('input[data-show-board]');

        if (btnKirimAspirasi) {
            btnKirimAspirasi.addEventListener('click', function(e) {
                e.preventDefault();
                const kategori = document.getElementById('selected-category')?.value || 'Akademik';
                const subjek = document.getElementById('aspirasi-subjek')?.value || '';
                const detail = document.getElementById('aspirasi-detail')?.value || '';
                const isAnonim = document.getElementById('anonim-checkbox')?.checked || false;
                const showOnBoard = showBoardCheckbox ? showBoardCheckbox.checked : false;
                const previewImgSrc = document.getElementById('image-preview').src;
                const hasImage = !document.getElementById('preview-container').classList.contains('hidden');

                if (!subjek.trim()) { alert('Mohon isi subjek laporan terlebih dahulu.'); return; }
                if (subjek.trim().length > 100) { alert('Subjek maksimal 100 karakter.'); return; }
                if (!detail.trim()) { alert('Mohon isi detail laporan terlebih dahulu.'); return; }
                if (detail.trim().length > 500) { alert('Detail maksimal 500 karakter.'); return; }

                document.getElementById('confirm-kategori').textContent = sanitizeHTML(kategori);
                document.getElementById('confirm-subjek').textContent = sanitizeHTML(subjek) || "(Tanpa Subjek)";
                document.getElementById('confirm-detail').textContent = sanitizeHTML(detail) || "(Tanpa Detail)";
                
                const imgWrapper = document.getElementById('confirm-img-wrapper');
                if (hasImage && previewImgSrc !== "#") {
                    imgWrapper.classList.remove('hidden');
                    document.getElementById('confirm-preview').src = previewImgSrc;
                } else { imgWrapper.classList.add('hidden'); }

                document.getElementById('confirm-anonim-status').style.display = isAnonim ? 'flex' : 'none';
                document.getElementById('confirm-board-status').style.display = showOnBoard ? 'flex' : 'none';
                document.getElementById('final-submit').dataset.showOnBoard = showOnBoard ? '1' : '0';

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }, 10);
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        }

        function closeModal() {
            if (!modalBox) return;
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        if (modal) {
            modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
        }

        const finalSubmitBtn = document.getElementById('final-submit');
        if (finalSubmitBtn) {
            finalSubmitBtn.addEventListener('click', async function() {
                try {
                    const kategoriEl = document.getElementById('selected-category');
                    const subjekEl = document.getElementById('aspirasi-subjek');
                    const detailEl = document.getElementById('aspirasi-detail');
                    const anonimCheckboxEl = document.getElementById('anonim-checkbox');
                    const fileInput = document.getElementById('bukti_foto');
                    const csrfEl = document.getElementById('csrf-token');
                    
                    if (!kategoriEl || !subjekEl || !detailEl || !csrfEl) { alert('Form tidak lengkap'); return; }
                    if (fileInput?.files[0]) {
                        const validation = validateFile(fileInput.files[0]);
                        if (!validation.valid) { alert(validation.message); return; }
                    }

                    const formData = new FormData();
                    formData.append('kategori', kategoriEl.value || 'Akademik');
                    formData.append('subjek', subjekEl.value);
                    formData.append('detail', detailEl.value);
                    formData.append('anonim', anonimCheckboxEl?.checked ? '1' : '0');
                    formData.append('show_on_board', this.dataset.showOnBoard || '0');
                    formData.append('csrf_token', csrfEl.value);
                    if (fileInput?.files[0]) formData.append('bukti_foto', fileInput.files[0]);

                    const response = await fetch('./api/submit-aspirasi.php', {
                        method: 'POST', body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();

                    if (result.success) {
                        alert('Aspirasi berhasil dikirim!');
                        closeModal();
                        subjekEl.value = '';
                        detailEl.value = '';
                        if (anonimCheckboxEl) anonimCheckboxEl.checked = false;
                        if (document.getElementById('anonim-switch')) document.getElementById('anonim-switch').setAttribute('aria-checked', 'false');
                        if (fileInput) fileInput.value = '';
                        document.getElementById('preview-container')?.classList.add('hidden');
                        document.getElementById('upload-placeholder')?.classList.remove('hidden');
                        if (charCount) charCount.textContent = '0';
                        categoryButtons.forEach(btn => { btn.classList.remove('active', 'text-white', 'bg-blue-900'); btn.classList.add('text-gray-700', 'hover:bg-gray-50'); btn.setAttribute('aria-checked', 'false'); });
                        if (categoryButtons[0]) { categoryButtons[0].classList.add('active', 'text-white', 'bg-blue-900'); categoryButtons[0].classList.remove('text-gray-700', 'hover:bg-gray-50'); categoryButtons[0].setAttribute('aria-checked', 'true'); }
                        kategoriEl.value = 'Akademik';
                    } else {
                        alert('Error: ' + (result.message || 'Gagal mengirim aspirasi'));
                    }
                } catch (error) {
                    alert('Terjadi kesalahan: ' + error.message);
                }
            });
        }
    </script>
</body>
</html>
