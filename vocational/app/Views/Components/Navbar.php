<!-- @Views/Components/Navbar.php -->
<nav class="bg-white border-b border-gray-200 px-6 md:px-16 py-3 flex justify-between items-center shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] sticky top-0 z-50">
    <button id="logo-button" type="button" 
            class="hover:scale-110 transition-transform duration-200 bg-transparent border-none p-0 cursor-pointer">
        <div class="flex items-center">
            <img src="/assets/img/logo-himatif.svg" alt="logo himatif" class="h-10 w-auto object-contain">
        </div>
    </button>
    
    <!-- Desktop Navigation -->
    <div class="hidden md:flex gap-8 text-sm font-medium text-gray-500 uppercase tracking-wider">
        <a href="/" class="<?= $active == 'beranda' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Beranda</a>
        <a href="/bulletin-board.php" class="<?= $active == 'papan-buletin' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Papan Buletin</a>
        <a href="#" class="<?= $active == 'riwayat' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Riwayat</a>
        <a href="/panduan.php" class="<?= $active == 'panduan' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Panduan</a>
    </div>

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-toggle" type="button" 
            class="md:hidden hover:scale-110 transition-transform duration-200 bg-transparent border-none p-0 cursor-pointer">
        <i data-lucide="menu" class="text-gray-600 w-6 h-6"></i>
    </button>

    <!-- Profile Dropdown Trigger -->
    <button id="profile-dropdown-trigger" type="button" 
            class="hover:scale-110 transition-transform duration-200 bg-transparent border-none p-0 cursor-pointer relative">
        <i data-lucide="user" class="text-gray-600 w-6 h-6"></i>
    </button>
</nav>

<!-- Profile Dropdown Menu -->
<div id="profile-dropdown" class="hidden fixed bg-white rounded-xl shadow-lg z-40 border border-gray-200 min-w-[200px]" 
     style="top: 60px; right: 24px;">
    <div class="flex flex-col py-2">
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], 'profile-navigation') !== false ? '../' : './') . 'profile-navigation/profile.php'; ?>" 
           class="px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors flex items-center gap-2">
            <i data-lucide="user-circle" class="w-4 h-4"></i>
            Profile
        </a>
        <a href="<?php echo (strpos($_SERVER['PHP_SELF'], 'profile-navigation') !== false ? '../' : './') . 'profile-navigation/settings.php'; ?>" 
           class="px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors flex items-center gap-2">
            <i data-lucide="settings" class="w-4 h-4"></i>
            Pengaturan
        </a>
        <div class="border-t border-gray-200 my-1"></div>
        <button id="btn-logout-modal" type="button"
                class="px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2 w-full text-left bg-none border-none cursor-pointer">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            Logout
        </button>
    </div>
</div>

<!-- Mobile Navigation Menu -->
<div id="mobile-menu" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden" style="top: 60px;">
    <div class="bg-white w-full shadow-lg animate-slide-down">
        <div class="flex flex-col gap-1 px-6 py-4">
            <a href="/" class="py-3 px-4 text-sm font-medium rounded-lg transition-colors <?= $active == 'beranda' ? 'bg-blue-50 text-blue-900' : 'text-gray-600 hover:bg-gray-50' ?>">
                Beranda
            </a>
            <a href="/bulletin-board.php" class="py-3 px-4 text-sm font-medium rounded-lg transition-colors <?= $active == 'papan-buletin' ? 'bg-blue-50 text-blue-900' : 'text-gray-600 hover:bg-gray-50' ?>">
                Papan Buletin
            </a>
            <a href="#" class="py-3 px-4 text-sm font-medium rounded-lg transition-colors <?= $active == 'riwayat' ? 'bg-blue-50 text-blue-900' : 'text-gray-600 hover:bg-gray-50' ?>">
                Riwayat
            </a>
            <a href="/panduan.php" class="py-3 px-4 text-sm font-medium rounded-lg transition-colors <?= $active == 'panduan' ? 'bg-blue-50 text-blue-900' : 'text-gray-600 hover:bg-gray-50' ?>">
                Panduan
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== MOBILE MENU LOGIC =====
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = mobileMenu;

        if (mobileMenuToggle && mobileMenu) {
            // Toggle menu visibility
            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });

            // Close menu when clicking on overlay
            mobileMenuOverlay.addEventListener('click', function(e) {
                if (e.target === mobileMenuOverlay) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Close menu when clicking on a link
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close menu when pressing Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        const logoButton = document.getElementById('logo-button');
        if (logoButton) {
            logoButton.addEventListener('click', function() {
                window.location.href = '/';
            });
        }

        // ===== PROFILE DROPDOWN LOGIC =====
        const profileDropdownTrigger = document.getElementById('profile-dropdown-trigger');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileDropdownTrigger && profileDropdown) {
            // Toggle dropdown visibility
            profileDropdownTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });

            // Close dropdown when clicking on a link
            const dropdownLinks = profileDropdown.querySelectorAll('a, button');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function() {
                    profileDropdown.classList.add('hidden');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !profileDropdownTrigger.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Close dropdown when pressing Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !profileDropdown.classList.contains('hidden')) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Close both menus when pressing Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                    if (!profileDropdown.classList.contains('hidden')) {
                        profileDropdown.classList.add('hidden');
                    }
                }
            });
        }
    });
</script>

<style>
    @keyframes slide-down {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-down {
        animation: slide-down 0.2s ease-out;
    }
</style>
