<!-- @Views/Components/Navbar.php -->
<nav aria-label="Navigasi utama" class="bg-white border-b border-gray-200 px-6 md:px-16 py-3 flex justify-between items-center shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] sticky top-0 z-50">
    <a href="/" aria-label="VocaTIonal - Kembali ke beranda"
       class="hover:scale-110 transition-transform duration-200 p-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded-lg">
        <img src="/assets/img/logo-himatif.svg" alt="" aria-hidden="true" class="h-10 w-auto object-contain">
    </a>
    
    <!-- Desktop Navigation -->
    <div class="hidden md:flex gap-8 text-sm font-medium text-gray-700 uppercase tracking-wider" role="list">
        <a href="/" role="listitem" <?= $active == 'beranda' ? 'aria-current="page"' : '' ?>
           class="<?= $active == 'beranda' ? 'text-blue-900 underline underline-offset-4' : 'hover:text-blue-900' ?> transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded px-1">Beranda</a>
        <a href="/bulletin-board.php" role="listitem" <?= $active == 'papan-buletin' ? 'aria-current="page"' : '' ?>
           class="<?= $active == 'papan-buletin' ? 'text-blue-900 underline underline-offset-4' : 'hover:text-blue-900' ?> transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded px-1">Papan Buletin</a>
        <a href="/riwayat.php" role="listitem" <?= $active == 'riwayat' ? 'aria-current="page"' : '' ?>
           class="<?= $active == 'riwayat' ? 'text-blue-900 underline underline-offset-4' : 'hover:text-blue-900' ?> transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded px-1">Riwayat</a>
        <a href="/panduan.php" role="listitem" <?= $active == 'panduan' ? 'aria-current="page"' : '' ?>
           class="<?= $active == 'panduan' ? 'text-blue-900 underline underline-offset-4' : 'hover:text-blue-900' ?> transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 rounded px-1">Panduan</a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-toggle" type="button" 
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="mobile-menu"
            class="md:hidden transition-transform duration-200 bg-transparent border-none p-2 cursor-pointer rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
        <i data-lucide="menu" aria-hidden="true" class="text-gray-700 w-6 h-6"></i>
    </button>

    <!-- Profile Dropdown Trigger -->
    <button id="profile-dropdown-trigger" type="button" 
            aria-label="Menu profil"
            aria-expanded="false"
            aria-haspopup="true"
            aria-controls="profile-dropdown"
            class="hidden md:block transition-transform duration-200 bg-transparent border-none p-2 cursor-pointer relative rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
        <i data-lucide="user" aria-hidden="true" class="text-gray-700 w-6 h-6"></i>
    </button>
</nav>

<!-- Profile Dropdown Menu -->
<div id="profile-dropdown" class="hidden fixed bg-white rounded-xl shadow-lg z-40 border border-gray-200 min-w-[200px]" 
     role="menu" aria-label="Menu profil"
     style="top: 60px; right: 24px;">
    <div class="flex flex-col py-2">
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], 'profile-navigation') !== false ? '../' : './') . 'profile-navigation/profile.php'; ?>" 
           role="menuitem"
           class="px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-900">
            <i data-lucide="user-circle" aria-hidden="true" class="w-4 h-4"></i>
            Profile
        </a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], 'profile-navigation') !== false ? '../' : './') . 'profile-navigation/settings.php'; ?>" 
           role="menuitem"
           class="px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors flex items-center gap-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-900">
            <i data-lucide="settings" aria-hidden="true" class="w-4 h-4"></i>
            Pengaturan
        </a>
        <div class="border-t border-gray-200 my-1" role="separator"></div>
        <button id="btn-logout-modal" type="button"
                role="menuitem"
                class="px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2 w-full text-left bg-none border-none cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-900">
            <i data-lucide="log-out" aria-hidden="true" class="w-4 h-4"></i>
            Logout
        </button>
    </div>
</div>

<!-- Mobile Navigation Menu -->
<div id="mobile-menu" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden" style="top: 60px;" role="dialog" aria-label="Menu navigasi mobile">
    <nav class="bg-white w-full shadow-lg animate-slide-down" aria-label="Navigasi mobile">
        <div class="flex flex-col gap-1 px-6 py-4">
            <a href="/" <?= $active == 'beranda' ? 'aria-current="page"' : '' ?>
               class="py-3 px-4 text-sm font-medium rounded-lg transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 <?= $active == 'beranda' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-50' ?>">
                Beranda
            </a>
            <a href="/bulletin-board.php" <?= $active == 'papan-buletin' ? 'aria-current="page"' : '' ?>
               class="py-3 px-4 text-sm font-medium rounded-lg transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 <?= $active == 'papan-buletin' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-50' ?>">
                Papan Buletin
            </a>
            <a href="/riwayat.php" <?= $active == 'riwayat' ? 'aria-current="page"' : '' ?>
               class="py-3 px-4 text-sm font-medium rounded-lg transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 <?= $active == 'riwayat' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-50' ?>">
                Riwayat
            </a>
            <a href="/panduan.php" <?= $active == 'panduan' ? 'aria-current="page"' : '' ?>
               class="py-3 px-4 text-sm font-medium rounded-lg transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 <?= $active == 'panduan' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-50' ?>">
                Panduan
            </a>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== MOBILE MENU LOGIC =====
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                this.setAttribute('aria-expanded', !isOpen);
                this.setAttribute('aria-label', isOpen ? 'Buka menu navigasi' : 'Tutup menu navigasi');
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });

            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenuToggle.setAttribute('aria-label', 'Buka menu navigasi');
                }
            });

            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                });
            });
        }

        // ===== PROFILE DROPDOWN LOGIC =====
        const profileDropdownTrigger = document.getElementById('profile-dropdown-trigger');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileDropdownTrigger && profileDropdown) {
            profileDropdownTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !profileDropdown.classList.contains('hidden');
                profileDropdown.classList.toggle('hidden');
                this.setAttribute('aria-expanded', !isOpen);
                if (!isOpen) {
                    // Focus first menu item when opening
                    const firstItem = profileDropdown.querySelector('[role="menuitem"]');
                    if (firstItem) firstItem.focus();
                }
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });

            // Keyboard navigation within dropdown
            profileDropdown.addEventListener('keydown', function(e) {
                const items = [...profileDropdown.querySelectorAll('[role="menuitem"]')];
                const currentIndex = items.indexOf(document.activeElement);

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const next = (currentIndex + 1) % items.length;
                    items[next].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prev = (currentIndex - 1 + items.length) % items.length;
                    items[prev].focus();
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    items[0].focus();
                } else if (e.key === 'End') {
                    e.preventDefault();
                    items[items.length - 1].focus();
                }
            });

            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !profileDropdownTrigger.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                    profileDropdownTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // ===== ESCAPE KEY - CLOSE ALL =====
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    mobileMenuToggle.setAttribute('aria-label', 'Buka menu navigasi');
                    mobileMenuToggle.focus();
                }
                if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                    profileDropdown.classList.add('hidden');
                    profileDropdownTrigger.setAttribute('aria-expanded', 'false');
                    profileDropdownTrigger.focus();
                }
            }
        });
    });
</script>

<style>
    @keyframes slide-down {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down { animation: slide-down 0.2s ease-out; }
</style>
