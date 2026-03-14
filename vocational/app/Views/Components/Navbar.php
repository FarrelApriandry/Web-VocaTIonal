<!-- @Views/Components/Navbar.php -->
<nav class="bg-white border-b border-gray-200 px-6 md:px-16 py-3 flex justify-between items-center shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] sticky top-0 z-50">
    <div class="flex items-center">
        <img src="./assets/img/logo-himatif.svg" alt="logo himatif" class="h-10 w-auto object-contain">
    </div>
    
    <div class="hidden md:flex gap-8 text-sm font-medium text-gray-500 uppercase tracking-wider">
        <a href="#" class="<?= $active == 'beranda' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Beranda</a>
        <a href="#" class="<?= $active == 'riwayat' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Riwayat</a>
        <a href="#" class="<?= $active == 'panduan' ? 'text-blue-900 underline' : 'hover:text-blue-900' ?> transition-colors duration-200">Panduan</a>
    </div>

    <div class="hover:scale-110 transition-transform duration-200">
        <i data-lucide="user" class="text-gray-600 w-6 h-6 cursor-pointer"></i>
    </div>
</nav>