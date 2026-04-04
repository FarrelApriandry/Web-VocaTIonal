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

// Import header & navbar
include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main class="mx-auto px-6 md:px-16 py-8 md:py-16">
    <div class="max-w-2xl">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8">
            Pengaturan <span class="text-blue-900">Akun</span>
        </h1>

        <div class="space-y-6">
            <!-- Privacy Settings -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Privasi</h2>
                
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" class="w-4 h-4">
                        <div>
                            <p class="font-semibold text-gray-900">Tampilkan Profile Saya</p>
                            <p class="text-xs text-gray-500">Izinkan mahasiswa lain melihat profile Anda</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" checked class="w-4 h-4">
                        <div>
                            <p class="font-semibold text-gray-900">Aspirasi Anonim Secara Default</p>
                            <p class="text-xs text-gray-500">Kirim aspirasi sebagai anonim ketika belum dipilih</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Notifikasi</h2>
                
                <div class="space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" checked class="w-4 h-4">
                        <div>
                            <p class="font-semibold text-gray-900">Notifikasi Aspirasi</p>
                            <p class="text-xs text-gray-500">Terima notifikasi saat aspirasi Anda mendapat respons</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer p-3 hover:bg-gray-50 rounded-lg transition">
                        <input type="checkbox" class="w-4 h-4">
                        <div>
                            <p class="font-semibold text-gray-900">Email Digest</p>
                            <p class="text-xs text-gray-500">Terima ringkasan mingguan aspirasi terbaru</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 border-l-4 border-red-500">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Zona Berbahaya</h2>
                
                <div class="space-y-4">
                    <button class="w-full px-6 py-3 border-2 border-red-500 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition-colors">
                        Hapus Semua Data Aspirasi
                    </button>

                    <button onclick="document.getElementById('btn-logout-modal').click()"
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Logout dari Semua Device
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
    // Include confirmation modal
    include $appDir . '/Views/Components/ConfirmationModal.php';
?>

<script src="/js/confirmation-modal.js"></script>

<script>
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
</body>
</html>
