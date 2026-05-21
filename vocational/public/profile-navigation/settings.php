<?php
session_start();

$title = "VocaTIonal | Settings";
$active = "settings";

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

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main id="main-content" class="mx-auto px-4 md:px-8 py-8 md:py-16 max-w-7xl">
    <div class="max-w-2xl">
    <header class="mb-8 md:mb-12">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 leading-tight">
            Pengaturan <span class="text-blue-900">Akun</span>
        </h1>
        <p class="text-sm md:text-base text-gray-600">Halo, <?= htmlspecialchars(explode(' ', $user['nama'])[0]) ?>. Kelola keamanan akun kamu di sini.</p>
    </header>

    <!-- Change Password -->
    <section class="glass-card p-5 md:p-8 shadow-sm mb-6" aria-labelledby="password-heading">
        <h2 id="password-heading" class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-5">Ubah Password</h2>
        <form id="change-password-form" class="space-y-3" novalidate>
            <input type="hidden" id="cp-csrf-token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <label for="current-password" class="block text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-1.5">Password Saat Ini</label>
                <input type="password" id="current-password" autocomplete="current-password"
                       class="w-full bg-gray-50 border border-gray-500 rounded-lg px-3 py-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                       aria-required="true" required>
            </div>
            <div>
                <label for="new-password" class="block text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-1.5">Password Baru</label>
                <input type="password" id="new-password" autocomplete="new-password" minlength="8"
                       class="w-full bg-gray-50 border border-gray-500 rounded-lg px-3 py-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                       aria-required="true" aria-describedby="pw-hint" required>
                <p id="pw-hint" class="text-[11px] text-gray-600 mt-1">Minimal 8 karakter. Hindari menggunakan NPM sebagai password.</p>
            </div>
            <div>
                <label for="confirm-password" class="block text-[10px] font-bold text-gray-700 uppercase tracking-widest mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" id="confirm-password" autocomplete="new-password" minlength="8"
                       class="w-full bg-gray-50 border border-gray-500 rounded-lg px-3 py-3 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-1"
                       aria-required="true" required>
            </div>
            <button type="submit" class="w-full sm:w-auto bg-[#111827] text-white px-8 py-3 rounded-lg font-medium uppercase tracking-widest hover:bg-black transition-all text-xs focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
                Simpan Password Baru
            </button>
            <div id="cp-message" role="alert" aria-live="polite" class="text-xs text-center hidden font-medium"></div>
        </form>
    </section>

    <!-- Danger Zone -->
    <section class="glass-card p-5 md:p-8 shadow-sm" aria-labelledby="danger-heading">
        <h2 id="danger-heading" class="text-xs font-bold text-red-600 uppercase tracking-widest mb-3">Zona Berbahaya</h2>
        <p class="text-xs text-gray-600 mb-4">Tindakan ini bersifat permanen dan tidak dapat dibatalkan.</p>
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="document.getElementById('btn-logout-modal').click()"
                    class="px-5 py-2.5 border-2 border-red-500 text-red-600 rounded-lg text-xs font-semibold hover:bg-red-50 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                Logout dari Akun
            </button>
        </div>
    </section>

    <!-- Back link -->
    <a href="./profile.php" class="inline-flex items-center gap-2 mt-6 text-xs font-semibold text-gray-700 hover:text-blue-900 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded">
        <i data-lucide="arrow-left" aria-hidden="true" class="w-4 h-4"></i> Kembali ke Profile
    </a>
    </div>
</main>

<?php include $appDir . '/Views/Components/ConfirmationModal.php'; ?>
<script src="/js/confirmation-modal.js"></script>

<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();

    document.getElementById('change-password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const msg = document.getElementById('cp-message');
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const csrfToken = document.getElementById('cp-csrf-token').value;

        msg.classList.add('hidden');
        msg.textContent = '';

        if (newPassword.length < 8) {
            msg.textContent = 'Password baru minimal 8 karakter';
            msg.className = 'text-sm text-center text-red-600 font-medium';
            msg.classList.remove('hidden');
            document.getElementById('new-password').focus();
            return;
        }
        if (newPassword !== confirmPassword) {
            msg.textContent = 'Password baru tidak cocok dengan konfirmasi';
            msg.className = 'text-sm text-center text-red-600 font-medium';
            msg.classList.remove('hidden');
            document.getElementById('confirm-password').focus();
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
            msg.className = 'text-sm text-center font-medium ' + (result.success ? 'text-green-700' : 'text-red-600');
            msg.classList.remove('hidden');
            if (result.success) this.reset();
        } catch (err) {
            msg.textContent = 'Terjadi kesalahan jaringan. Coba lagi.';
            msg.className = 'text-sm text-center text-red-600 font-medium';
            msg.classList.remove('hidden');
        }
    });
</script>
</body>
</html>
