<?php
// START SESSION
session_start();

// Props
$title = "VocaTIonal | Settings";
$active = "settings";

// Determine base paths from current file location
$publicDir = dirname(dirname(__FILE__)); // /var/www/html/public
$appDir = dirname($publicDir) . '/app'; // /var/www/html/app

// Import components
require_once $appDir . '/Config/Database.php';
require_once $appDir . '/Controllers/Auth.php';

// Check auth
$auth = new Auth();
if (!$auth->check()) {
    header('Location: ../');
    exit;
}

$user = $auth->user();

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Import header & navbar
include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main class="mx-auto px-6 md:px-16 py-8 md:py-16">
    <!-- Hero Section -->
    <section class="mb-12">
        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
            Pengaturan <span class="text-blue-900">Akun</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-500">Kelola keamanan, privasi, dan preferensi akun kamu</p>
    </section>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column: Password Change -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ubah Password Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-blue-900 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-1">Ubah Password</h2>
                        <p class="text-sm text-gray-500">Pastikan password baru kamu kuat dan mudah diingat</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i data-lucide="key-round" class="w-6 h-6 text-blue-900"></i>
                    </div>
                </div>
                <form id="change-password-form" class="space-y-4">
                    <input type="hidden" id="cp-csrf-token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-2">Password Saat Ini</label>
                        <input type="password" id="current-password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-900 focus:ring-1 focus:ring-blue-900" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-2">Password Baru</label>
                        <input type="password" id="new-password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-900 focus:ring-1 focus:ring-blue-900" minlength="8" required>
                        <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-2">Konfirmasi Password Baru</label>
                        <input type="password" id="confirm-password" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-900 focus:ring-1 focus:ring-blue-900" minlength="8" required>
                    </div>
                    <button type="submit" class="w-full px-6 py-4 bg-[#111827] text-white rounded-xl font-medium uppercase tracking-widest hover:bg-black transition-all text-sm">
                        Simpan Password Baru
                    </button>
                    <p id="cp-message" class="text-sm text-center hidden"></p>
                </form>
            </div>

            <!-- Privacy Settings Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-1">Privasi</h2>
                        <p class="text-sm text-gray-500">Kontrol siapa yang bisa melihat data kamu</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i data-lucide="eye-off" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>
                <div class="space-y-4">
                    <label class="flex items-center gap-4 cursor-pointer p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                        <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-blue-900 focus:ring-blue-900">
                        <div>
                            <p class="font-semibold text-gray-900">Tampilkan Profile Saya</p>
                            <p class="text-xs text-gray-500">Izinkan mahasiswa lain melihat profile Anda</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-4 cursor-pointer p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                        <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-blue-900 focus:ring-blue-900">
                        <div>
                            <p class="font-semibold text-gray-900">Aspirasi Anonim Secara Default</p>
                            <p class="text-xs text-gray-500">Kirim aspirasi sebagai anonim ketika belum dipilih</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Column: Info Cards -->
        <div class="space-y-6">
            <!-- Notification Settings -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Notifikasi</p>
                        <p class="text-lg font-bold text-gray-900">Preferensi</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i data-lucide="bell" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                        <input type="checkbox" checked class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Notifikasi Aspirasi</p>
                            <p class="text-xs text-gray-500">Respons aspirasi Anda</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition">
                        <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Email Digest</p>
                            <p class="text-xs text-gray-500">Ringkasan mingguan</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Security Info Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-md p-6 md:p-8 border border-blue-200/50">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-xs font-bold uppercase tracking-widest text-blue-900">Keamanan Aktif</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Enkripsi End-to-End</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                    Data kamu dilindungi dengan enkripsi. Session aktif selama 60 menit.
                </p>
                <div class="flex items-center gap-2 text-sm text-blue-900 font-semibold">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Terverifikasi</span>
                </div>
            </div>

            <!-- Back to Profile -->
            <a href="./profile.php" class="block bg-white rounded-2xl shadow-md p-6 border-l-4 border-cyan-500 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Navigasi</p>
                        <p class="text-lg font-bold text-cyan-600">Kembali ke Profile</p>
                    </div>
                    <div class="p-3 bg-cyan-100 rounded-lg">
                        <i data-lucide="arrow-left" class="w-6 h-6 text-cyan-600"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Danger Zone - Full Width -->
    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-3xl p-8 border border-red-200/50 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Zona Berbahaya</h3>
            <p class="text-gray-600">Tindakan di bawah ini bersifat permanen dan tidak dapat dibatalkan.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <button class="px-6 py-3 border-2 border-red-500 text-red-600 rounded-xl font-semibold hover:bg-red-100 transition-colors whitespace-nowrap">
                Hapus Data Aspirasi
            </button>
            <button onclick="document.getElementById('btn-logout-modal').click()"
                    class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all shadow-md whitespace-nowrap flex items-center justify-center gap-2">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Logout Semua Device
            </button>
        </div>
    </div>
</main>

<?php 
    include $appDir . '/Views/Components/ConfirmationModal.php';
?>

<script src="/js/confirmation-modal.js"></script>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Change Password Handler
    document.getElementById('change-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const msg = document.getElementById('cp-message');
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const csrfToken = document.getElementById('cp-csrf-token').value;

        if (newPassword.length < 8) {
            msg.textContent = 'Password baru minimal 8 karakter';
            msg.className = 'text-sm text-center text-red-600';
            msg.classList.remove('hidden');
            return;
        }
        if (newPassword !== confirmPassword) {
            msg.textContent = 'Password baru tidak cocok';
            msg.className = 'text-sm text-center text-red-600';
            msg.classList.remove('hidden');
            return;
        }

        try {
            const res = await fetch('../api/change-password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ current_password: currentPassword, new_password: newPassword, confirm_password: confirmPassword, csrf_token: csrfToken })
            });
            const result = await res.json();
            msg.textContent = result.message;
            msg.className = 'text-sm text-center ' + (result.success ? 'text-green-600' : 'text-red-600');
            msg.classList.remove('hidden');
            if (result.success) this.reset();
        } catch (err) {
            msg.textContent = 'Terjadi kesalahan. Coba lagi.';
            msg.className = 'text-sm text-center text-red-600';
            msg.classList.remove('hidden');
        }
    });
</script>
</body>
</html>
