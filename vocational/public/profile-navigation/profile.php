<?php
session_start();

$title = "VocaTIonal | Profile";
$active = "profile";

$publicDir = dirname(dirname(__FILE__));
$appDir = dirname($publicDir) . '/app';

require_once $appDir . '/Config/Database.php';
require_once $appDir . '/Controllers/Auth.php';

$auth = new Auth();
if (!$auth->check()) {
    header('Location: ../');
    exit;
}

$user = $auth->user();
$remainingMinutes = floor($user['remaining_time'] / 60);

include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main id="main-content" class="mx-auto px-6 md:px-16 py-8 md:py-16 max-w-3xl">
    <header class="mb-8 md:mb-12">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
            Selamat Datang, <span class="text-blue-900"><?= htmlspecialchars(explode(' ', $user['nama'])[0]) ?></span>
        </h1>
        <p class="text-sm md:text-base text-gray-600">Informasi akun dan session kamu saat ini.</p>
    </header>

    <!-- Profile Info -->
    <section class="glass-card p-5 md:p-8 shadow-sm mb-6" aria-labelledby="info-heading">
        <h2 id="info-heading" class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-5">Informasi Akun</h2>
        <dl class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <dt class="text-[10px] font-bold text-gray-700 uppercase tracking-widest w-32 flex-shrink-0">Nama Lengkap</dt>
                <dd class="text-sm text-gray-900 font-medium"><?= htmlspecialchars($user['nama']) ?></dd>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <dt class="text-[10px] font-bold text-gray-700 uppercase tracking-widest w-32 flex-shrink-0">NPM</dt>
                <dd class="text-sm text-gray-900 font-medium font-mono"><?= htmlspecialchars($user['npm']) ?></dd>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <dt class="text-[10px] font-bold text-gray-700 uppercase tracking-widest w-32 flex-shrink-0">Status</dt>
                <dd class="text-sm text-green-700 font-medium flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full inline-block" aria-hidden="true"></span>
                    Aktif
                </dd>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <dt class="text-[10px] font-bold text-gray-700 uppercase tracking-widest w-32 flex-shrink-0">Tipe Akses</dt>
                <dd class="text-sm text-gray-900 font-medium">Mahasiswa</dd>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <dt class="text-[10px] font-bold text-gray-700 uppercase tracking-widest w-32 flex-shrink-0">Sisa Session</dt>
                <dd class="text-sm text-gray-900 font-medium"><?= $remainingMinutes ?> menit</dd>
            </div>
        </dl>
    </section>

    <!-- Quick Actions -->
    <section class="glass-card p-5 md:p-8 shadow-sm mb-6" aria-labelledby="actions-heading">
        <h2 id="actions-heading" class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-5">Aksi Cepat</h2>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="./settings.php" class="px-5 py-2.5 bg-[#111827] text-white rounded-lg text-xs font-medium uppercase tracking-widest hover:bg-black transition-all text-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
                Ubah Password
            </a>
            <button onclick="document.getElementById('btn-logout-modal').click()"
                    class="px-5 py-2.5 border-2 border-red-500 text-red-600 rounded-lg text-xs font-semibold hover:bg-red-50 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                Logout
            </button>
        </div>
    </section>

    <a href="/" class="inline-flex items-center gap-2 mt-6 text-xs font-semibold text-gray-700 hover:text-blue-900 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded">
        ← Kembali ke Beranda
    </a>
</main>

<?php include $appDir . '/Views/Components/ConfirmationModal.php'; ?>
<script src="/js/confirmation-modal.js"></script>
<script>if (typeof lucide !== 'undefined') lucide.createIcons();</script>
</body>
</html>
