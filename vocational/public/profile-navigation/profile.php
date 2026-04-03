<?php
// START SESSION
session_start();

// Props
$title = "VocaTIonal | Profile";
$active = "profile";

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

// Import header & navbar
include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main class="mx-auto px-6 md:px-16 py-8 md:py-16">
    <!-- Hero Section dengan Profile Icon -->
    <section class="mb-12 text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-2">
            Selamat Datang, <span class="text-blue-900"><?= htmlspecialchars(explode(' ', $user['nama'])[0]) ?></span>
        </h1>
        <p class="text-lg text-gray-500">Kelola profil dan pengaturan akun kamu di sini</p>
    </section>

    <!-- Main Profile Card dengan Glassmorphism -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Profile Card Utama -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-lg p-8 backdrop-blur-sm border border-blue-200/50">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-blue-100 mb-6 shadow-xl ring-4 ring-white">
                        <i data-lucide="user" class="w-16 h-16 text-blue-900"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1"><?= htmlspecialchars($user['nama']) ?></h2>
                    <p class="text-sm text-gray-600 mb-4">NPM: <?= htmlspecialchars($user['npm']) ?></p>
                    
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 rounded-full mb-6">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-green-700">Aktif</span>
                    </div>

                    <!-- Session Timer -->
                    <div class="bg-white rounded-2xl p-4 mb-6">
                        <p class="text-xs text-gray-500 mb-2">Sisa Waktu Session</p>
                        <p class="text-2xl font-bold text-blue-900" id="session-timer">--:--</p>
                    </div>

                    <!-- Edit Profile Button -->
                    <button onclick="alert('Fitur edit profile akan segera tersedia')" 
                            class="w-full px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-800 transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md mb-3 flex items-center justify-center gap-2">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Cards Grid -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Row 1: NPM & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NPM Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-900 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nomor Pokok Mahasiswa</p>
                            <p class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($user['npm']) ?></p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i data-lucide="id-card" class="w-6 h-6 text-blue-900"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Identitas Unik Mahasiswa</p>
                </div>
                
                <!-- Name Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</p>
                            <p class="text-2xl font-bold text-gray-900 line-clamp-2"><?= htmlspecialchars($user['nama']) ?></p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i data-lucide="user" class="w-6 h-6 text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Data profil lengkap</p>
                </div>
            </div>

            <!-- Row 2: Name & Permissions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Account Status</p>
                            <p class="text-xl font-bold text-green-600">Aktif</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Akun kamu dalam kondisi baik</p>
                </div>

                <!-- Permissions Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe Akses</p>
                            <p class="text-xl font-bold text-orange-600">Mahasiswa</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i data-lucide="shield" class="w-6 h-6 text-orange-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Akses penuh ke fitur platform</p>
                </div>
            </div>

            <!-- Row 3: Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Settings Button Card -->
                <a href="./settings.php" class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-cyan-500 hover:shadow-lg transition-all hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pengaturan Akun</p>
                            <p class="text-lg font-bold text-cyan-600">Buka Pengaturan</p>
                        </div>
                        <div class="p-3 bg-cyan-100 rounded-lg">
                            <i data-lucide="settings" class="w-6 h-6 text-cyan-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Kelola privasi & notifikasi</p>
                </a>

                <!-- Security Card -->
                <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Keamanan</p>
                            <p class="text-lg font-bold text-red-600">Enkripsi End-to-End</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i data-lucide="lock" class="w-6 h-6 text-red-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Data kamu terlindungi dengan baik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Section -->
    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-3xl p-8 border border-red-200/50 flex flex-col md:flex-row items-center justify-between">
        <div class="mb-6 md:mb-0">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Ingin Logout?</h3>
            <p class="text-gray-600">Keluar dari akun kamu sekarang. Pastikan tidak ada pekerjaan yang belum tersimpan.</p>
        </div>
        <button onclick="document.getElementById('btn-logout-modal').click()" 
                class="px-8 py-4 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg whitespace-nowrap flex items-center gap-2">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            Logout Sekarang
        </button>
    </div>
</main>

<script>
    // Session timer
    function updateSessionTimer() {
        const storedTime = sessionStorage.getItem('remainingTime');
        if (storedTime) {
            const minutes = Math.floor(storedTime / 60);
            const seconds = storedTime % 60;
            document.getElementById('session-timer').textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }
    }

    updateSessionTimer();
    setInterval(updateSessionTimer, 1000);

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<?php 
    // Include confirmation modal
    include $appDir . '/Views/Components/ConfirmationModal.php';
?>

<script src="/js/confirmation-modal.js"></script>
</body>
</html>