<?php
// vocational/admin/board.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

// Auth check
require_once __DIR__ . '/../app/Controllers/AdminAuth.php';

if (!AdminAuth::check()) {
    header('Location: ./auth/login.php');
    exit;
}

$currentPage = 'board';
$title = "VocaTIonal | Papan Buletin";
?>
<?php include __DIR__ . '/components/Header.php'; ?>
<body class="bg-gray-50">
    <div class="md:flex min-h-screen">
        <!-- Include Sidebar -->
        <?php include __DIR__ . '/components/Sidebar.php'; ?>

        <!-- Main Container -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-6 md:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button 
                            id="sidebar-toggle-header" 
                            class="md:hidden text-gray-700 hover:text-gray-900"
                            onclick="toggleSidebar()"
                        >
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">Papan Buletin</h1>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 px-6 md:px-8 py-8 overflow-auto">
                <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                    <i data-lucide="construction" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Halaman Sedang Dikembangkan</h2>
                    <p class="text-gray-600 mb-6">Fitur papan buletin akan segera tersedia. Terima kasih atas kesabaran Anda.</p>
                    <a href="./dashboard.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Kembali ke Dashboard
                    </a>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>