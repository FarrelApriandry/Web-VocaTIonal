<?php

// Get current page from parameter with defensive check
$currentPage = isset($currentPage) && !empty($currentPage) ? $currentPage : 'dashboard';
?>

<!-- Sidebar -->
<aside id="sidebar" class="fixed md:sticky md:block top-0 left-0 w-64 h-screen bg-white border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-30">
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200">
        <div class="flex items-center gap-2">
            <img src="/assets/img/logo-himatif.svg" alt="Logo" class="h-6 w-auto">
            <span class="font-bold text-gray-900 text-sm">Admin Panel</span>
        </div>
        <button 
            id="sidebar-close" 
            class="md:hidden text-gray-500 hover:text-gray-700"
            onclick="toggleSidebar()"
        >
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="px-4 py-6 space-y-2">
        <!-- Dashboard -->
        <a 
            href="./index.php?action=dashboard" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors <?php echo $currentPage === 'dashboard' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100'; ?>"
        >
            <i data-lucide="layout-grid" class="w-5 h-5"></i>
            <span class="font-medium text-sm">Dashboard</span>
            <?php if ($currentPage === 'dashboard'): ?>
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            <?php endif; ?>
        </a>

        <!-- Aspirasi -->
        <a 
            href="./index.php?action=aspirations" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors <?php echo $currentPage === 'aspirations' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100'; ?>"
        >
            <i data-lucide="list" class="w-5 h-5"></i>
            <span class="font-medium text-sm">Aspirasi</span>
            <?php if ($currentPage === 'aspirations'): ?>
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            <?php endif; ?>
        </a>

        <!-- Laporan -->
        <a 
            href="./index.php?action=reports" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors <?php echo $currentPage === 'reports' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100'; ?>"
        >
            <i data-lucide="flag" class="w-5 h-5"></i>
            <span class="font-medium text-sm">Laporan</span>
            <?php if ($currentPage === 'reports'): ?>
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            <?php endif; ?>
        </a>

        <!-- Board -->
        <a 
            href="./index.php?action=board" 
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors <?php echo $currentPage === 'board' ? 'bg-blue-50 text-blue-900' : 'text-gray-700 hover:bg-gray-100'; ?>"
        >
            <i data-lucide="layout" class="w-5 h-5"></i>
            <span class="font-medium text-sm">Papan Buletin</span>
            <?php if ($currentPage === 'board'): ?>
                <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
            <?php endif; ?>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-6 left-4 right-4 pt-4 border-t border-gray-200">
        <button 
            onclick="logout()"
            class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium text-sm"
        >
            <i data-lucide="log-out" class="w-5 h-5"></i>
            <span>Logout</span>
        </button>
    </div>
</aside>

<!-- Sidebar Overlay (Mobile) -->
<div 
    id="sidebar-overlay" 
    class="fixed inset-0 bg-black bg-opacity-50 md:hidden hidden z-20"
    onclick="toggleSidebar()"
></div>

<!-- Sidebar Toggle Button (Mobile) -->
<button 
    id="sidebar-toggle" 
    class="md:hidden fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors z-40"
    onclick="toggleSidebar()"
>
    <i data-lucide="menu" class="w-6 h-6"></i>
</button>

<script>
    // Toggle sidebar visibility
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');
        
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        toggle.classList.toggle('hidden');
    }

    // Close sidebar when clicking on a link
    document.querySelectorAll('#sidebar nav a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });
    });

    // Close sidebar on window resize to desktop
    window.addEventListener('resize', () => {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('sidebar-toggle');
        
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            toggle.classList.add('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            toggle.classList.add('hidden');
        }
    });
</script>