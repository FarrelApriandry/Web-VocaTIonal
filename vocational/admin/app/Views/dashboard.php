<?php
// vocational/admin/public/dashboard.php
// Pure view file - NO logic, only HTML display
// Variables passed from DashboardController via renderLayout()
?>
<body class="bg-gray-50">
    <div class="md:flex min-h-screen">
        <!-- Include Sidebar -->
        <?php 
            $currentPage = 'dashboard';
            include __DIR__ . '/../app/Views/Components/Sidebar.php';  
        ?>

        <!-- Main Container -->
        <div class="flex-1 flex flex-col">
            <!-- Main Content -->
            <main class="flex-1 px-6 md:px-8 py-8 overflow-auto">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <p class="text-gray-600 text-sm">Ringkasan sistem aspirasi mahasiswa</p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <!-- Total Aspirations -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Aspirasi</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo $totalAspirations ?? 0; ?></p>
                            </div>
                            <div class="bg-blue-100 rounded-lg p-3">
                                <i data-lucide="inbox" class="w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Aspirations -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                                <p class="text-3xl font-bold text-amber-600 mt-2"><?php echo $pendingAspirations ?? 0; ?></p>
                            </div>
                            <div class="bg-amber-100 rounded-lg p-3">
                                <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- On Board -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Di Board</p>
                                <p class="text-3xl font-bold text-emerald-600 mt-2"><?php echo $onBoard ?? 0; ?></p>
                            </div>
                            <div class="bg-emerald-100 rounded-lg p-3">
                                <i data-lucide="check-square" class="w-6 h-6 text-emerald-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Reports -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Laporan</p>
                                <p class="text-3xl font-bold text-red-600 mt-2"><?php echo $pendingReports ?? 0; ?></p>
                            </div>
                            <div class="bg-red-100 rounded-lg p-3">
                                <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Reported Section -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i data-lucide="trending-up" class="w-5 h-5 text-red-600"></i>
                            Aspirasi Paling Banyak Dilaporkan
                        </h3>
                    </div>

                    <?php if (isset($mostReported) && is_array($mostReported) && count($mostReported) > 0): ?>
                        <div class="divide-y divide-gray-100">
                            <?php foreach ($mostReported as $report): ?>
                                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900">
                                                <span class="text-gray-500">#<?php echo htmlspecialchars($report['id_aspirasi']); ?></span> — <?php echo htmlspecialchars(substr($report['judul'], 0, 50)); ?>
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i data-lucide="flag" class="w-3 h-3 inline mr-1"></i>
                                                <?php echo htmlspecialchars($report['report_count']); ?> laporan
                                            </p>
                                        </div>
                                        <button 
                                            class="px-3 py-1.5 text-sm bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors font-medium whitespace-nowrap"
                                            onclick="viewAspirationDetail(<?php echo $report['id_aspirasi']; ?>)"
                                        >
                                            Lihat
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="px-6 py-12 text-center">
                            <i data-lucide="inbox" class="w-10 h-10 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500 text-sm font-medium">Tidak ada laporan pending</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Manage Aspirations -->
                    <a href="./index.php?action=aspirations" class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-sm transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-blue-100 rounded-lg p-3 flex-shrink-0">
                                <i data-lucide="list" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kelola Aspirasi</h4>
                                <p class="text-xs text-gray-600 mt-1">Lihat dan perbarui status</p>
                            </div>
                        </div>
                    </a>

                    <!-- Reports Management -->
                    <a href="./index.php?action=reports" class="bg-white rounded-lg border border-gray-200 p-6 hover:border-red-300 hover:shadow-sm transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-100 rounded-lg p-3 flex-shrink-0">
                                <i data-lucide="flag" class="w-5 h-5 text-red-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kelola Laporan</h4>
                                <p class="text-xs text-gray-600 mt-1"><?php echo $pendingReports ?? 0; ?> menunggu review</p>
                            </div>
                        </div>
                    </a>

                    <!-- Board Management -->
                    <a href="./index.php?action=board" class="bg-white rounded-lg border border-gray-200 p-6 hover:border-emerald-300 hover:shadow-sm transition-all">
                        <div class="flex items-start gap-3">
                            <div class="bg-emerald-100 rounded-lg p-3 flex-shrink-0">
                                <i data-lucide="layout" class="w-5 h-5 text-emerald-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Papan Buletin</h4>
                                <p class="text-xs text-gray-600 mt-1"><?php echo $onBoard ?? 0; ?> aspirasi aktif</p>
                            </div>
                        </div>
                    </a>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Logout function
        function logout() {
            if (confirm('Anda yakin ingin logout?')) {
                window.location.href = './api/admin-logout.php';
            }
        }

        // View aspiration detail
        function viewAspirationDetail(id) {
            window.location.href = './index.php?action=aspirations&id=' + id;
        }

        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>