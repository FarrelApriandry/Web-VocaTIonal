<?php
// vocational/admin/app/Views/Layouts/main.php
// Main layout wrapper for admin panel
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><?= $title ?? 'VocaTIonal Admin' ?> | Admin Panel</title>
    <meta name="title" content="<?= $title ?? 'VocaTIonal Admin' ?> - Admin Panel">
    <meta name="description" content="Panel administrasi VocaTIonal - Kelola aspirasi mahasiswa, rapor, dan papan buletin dengan mudah.">
    <meta name="keywords" content="VocaTIonal Admin, Admin Panel, Kelola Aspirasi, Teknik Informatika, Tidar University">
    <meta name="author" content="Tim VocaTIonal">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://vocational.info/admin/">
    <meta property="og:title" content="<?= $title ?? 'VocaTIonal Admin' ?> - Admin Panel">
    <meta property="og:description" content="Panel administrasi VocaTIonal untuk mengelola aspirasi, laporan, dan papan buletin mahasiswa.">
    <meta property="og:image" content="https://vocational.info/assets/img/logo-himatif.svg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://vocational.info/admin/">
    <meta property="twitter:title" content="<?= $title ?? 'VocaTIonal Admin' ?> - Admin Panel">
    <meta property="twitter:description" content="Kelola aspirasi mahasiswa, tandai laporan, dan publikasikan di papan buletin.">
    <meta property="twitter:image" content="https://vocational.info/assets/img/logo-himatif.svg">

    <link rel="icon" type="image/svg+xml" href="./assets/img/logo-himatif.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F3F4F6; }
        .glass-card { background: white; border-radius: 24px; border: 1px solid #E5E7EB; }
        .btn-category { border: 1px solid #9CA3AF; border-radius: 12px; transition: all 0.3s; }
        .btn-category.active { background-color: #1E3A8A; color: white; border-color: #1E3A8A; }
        .info-card { background-color: #1E3A8A; border-radius: 16px; color: white; }
        input:checked ~ .dot { transform: translateX(1.5rem); background-color: #DBEAFE; }
        input:checked ~ .block { background-color: #1E3A8A; }
        .fade-out { opacity: 0; transition: opacity 0.5s ease-out; pointer-events: none; }
        .fade-in { opacity: 1 !important; transform: translateY(0) !important; transition: all 0.6s ease-out; }
        #main-content { opacity: 0; transform: translateY(10px); }
    </style>
</head>
<body class="min-h-screen">
    <div class="md:flex min-h-screen">
        <!-- Sidebar Component -->
        <?php 
            $currentPage = $currentPage ?? 'dashboard';
            include __DIR__ . '/../Components/Sidebar.php';  
        ?>

        <!-- Main Container -->
        <div class="flex-1 flex flex-col">
            <!-- Header Section -->
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
                            <h1 class="text-lg font-bold text-gray-900"><?= $title ?? 'Dashboard' ?></h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Admin Info -->
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-900"><?php echo isset($admin) ? htmlspecialchars($admin['username'] ?? '') : 'Admin'; ?></p>
                            <p class="text-xs text-gray-500 capitalize"><?php echo isset($admin) ? htmlspecialchars($admin['role'] ?? '') : ''; ?></p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto">
                <?php echo $content; ?>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle = document.getElementById('sidebar-toggle');
            
            if (sidebar && overlay && toggle) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                toggle.classList.toggle('hidden');
            }
        }

        // Logout function
        function logout() {
            if (confirm('Anda yakin ingin logout?')) {
                window.location.href = './api/admin-logout.php';
            }
        }

        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>