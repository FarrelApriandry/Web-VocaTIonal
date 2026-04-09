<?php
// vocational/admin/app/Views/reports.php
// Pure view file - NO logic, only HTML display
// Variables passed from ReportsController via renderLayout()
?>
<body class="bg-gray-50">
    <div class="md:flex min-h-screen">
        <!-- Include Sidebar -->
        <?php 
            // $currentPage = 'reports';
            // include __DIR__ . '/Components/Sidebar.php';  
        ?>

        <!-- Main Container -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <!-- <header class="bg-white/50 border-b border-gray-200 sticky top-0 z-40">
                <div class="px-6 md:px-8 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Kelola Laporan</h1>
                        <p class="text-xs text-gray-600 mt-1">Total: <span class="font-semibold"><?php echo $totalCount ?? 0; ?></span> laporan</p>
                    </div>
                </div>
            </header> -->

            <!-- Main Content -->
            <main class="flex-1 px-6 md:px-8 py-8 overflow-auto">
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <!-- Total Pending -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                                <p class="text-2xl font-bold text-amber-600 mt-1"><?php echo $stats['total_pending'] ?? 0; ?></p>
                            </div>
                            <div class="bg-amber-100 rounded-lg p-2.5">
                                <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Inappropriate Count -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tidak Pantas</p>
                                <p class="text-2xl font-bold text-red-600 mt-1"><?php echo $stats['inappropriate_count'] ?? 0; ?></p>
                            </div>
                            <div class="bg-red-100 rounded-lg p-2.5">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Spam Count -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Spam</p>
                                <p class="text-2xl font-bold text-orange-600 mt-1"><?php echo $stats['spam_count'] ?? 0; ?></p>
                            </div>
                            <div class="bg-orange-100 rounded-lg p-2.5">
                                <i data-lucide="mail-x" class="w-5 h-5 text-orange-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Offensive Count -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Menyerang</p>
                                <p class="text-2xl font-bold text-purple-600 mt-1"><?php echo $stats['offensive_count'] ?? 0; ?></p>
                            </div>
                            <div class="bg-purple-100 rounded-lg p-2.5">
                                <i data-lucide="zap" class="w-5 h-5 text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <form method="GET" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="action" value="reports">
                        
                        <!-- Status Filter -->
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" <?php echo ($status_filter ?? 'pending') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="">Semua Status</option>
                                <option value="confirmed" <?php echo ($status_filter ?? '') === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="processing" <?php echo ($status_filter ?? '') === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="resolved" <?php echo ($status_filter ?? '') === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                <option value="dismissed" <?php echo ($status_filter ?? '') === 'dismissed' ? 'selected' : ''; ?>>Dismissed</option>
                            </select>
                        </div>

                        <!-- Reason Filter -->
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Alasan</label>
                            <select name="reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Alasan</option>
                                <option value="inappropriate" <?php echo ($reason_filter ?? '') === 'inappropriate' ? 'selected' : ''; ?>>Tidak Pantas</option>
                                <option value="spam" <?php echo ($reason_filter ?? '') === 'spam' ? 'selected' : ''; ?>>Spam</option>
                                <option value="offensive" <?php echo ($reason_filter ?? '') === 'offensive' ? 'selected' : ''; ?>>Menyerang</option>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Kategori</label>
                            <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                <option value="Akademik" <?php echo ($kategori_filter ?? '') === 'Akademik' ? 'selected' : ''; ?>>Akademik</option>
                                <option value="Fasilitas" <?php echo ($kategori_filter ?? '') === 'Fasilitas' ? 'selected' : ''; ?>>Fasilitas</option>
                                <option value="Sarpras" <?php echo ($kategori_filter ?? '') === 'Sarpras' ? 'selected' : ''; ?>>Sarpras</option>
                                <option value="Layanan" <?php echo ($kategori_filter ?? '') === 'Layanan' ? 'selected' : ''; ?>>Layanan</option>
                                <option value="UKT" <?php echo ($kategori_filter ?? '') === 'UKT' ? 'selected' : ''; ?>>UKT</option>
                                <option value="Lainnya" <?php echo ($kategori_filter ?? '') === 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="flex items-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium whitespace-nowrap">
                                <i data-lucide="search" class="w-4 h-4 inline mr-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reports Table -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <?php if (isset($allReports) && is_array($allReports) && count($allReports) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Aspirasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alasan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Laporan Serupa</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Dibuat</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($allReports as $report): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">#<?php echo htmlspecialchars($report['id_report']); ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="flex items-start gap-2">
                                                    <div>
                                                        <p class="font-medium"><?php echo htmlspecialchars(substr($report['judul'], 0, 50)); ?></p>
                                                        <p class="text-xs text-gray-500 mt-0.5">Aspirasi #<?php echo $report['id_aspirasi']; ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <?php
                                                    $reasonMap = [
                                                        'inappropriate' => ['Tidak Pantas', 'bg-red-100', 'text-red-800'],
                                                        'spam' => ['Spam', 'bg-orange-100', 'text-orange-800'],
                                                        'offensive' => ['Menyerang', 'bg-purple-100', 'text-purple-800']
                                                    ];
                                                    $reason = $reasonMap[$report['reason']] ?? ['Unknown', 'bg-gray-100', 'text-gray-800'];
                                                ?>
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium <?php echo $reason[1] . ' ' . $reason[2]; ?>">
                                                    <?php echo $reason[0]; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($report['kategori']); ?></td>
                                            <td class="px-6 py-4 text-sm">
                                                <?php
                                                    $statusMap = [
                                                        'pending' => ['Pending', 'bg-amber-100', 'text-amber-800'],
                                                        'confirmed' => ['Confirmed', 'bg-blue-100', 'text-blue-800'],
                                                        'processing' => ['Processing', 'bg-indigo-100', 'text-indigo-800'],
                                                        'resolved' => ['Resolved', 'bg-emerald-100', 'text-emerald-800'],
                                                        'dismissed' => ['Dismissed', 'bg-gray-100', 'text-gray-800']
                                                    ];
                                                    $status = $statusMap[$report['status']] ?? ['Unknown', 'bg-gray-100', 'text-gray-800'];
                                                ?>
                                                <span class="px-2.5 py-1 rounded-full text-xs font-medium <?php echo $status[1] . ' ' . $status[2]; ?>">
                                                    <?php echo $status[0]; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-center">
                                                <?php if ($report['similar_reports'] > 0): ?>
                                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                                        <?php echo $report['similar_reports']; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-gray-400">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                <?php echo date('d M Y', strtotime($report['created_at'])); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-center">
                                                <button 
                                                    class="px-3 py-1.5 text-xs font-medium bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition-colors"
                                                    onclick="openReportDetail(<?php echo $report['id_report']; ?>)"
                                                >
                                                    <i data-lucide="eye" class="w-3 h-3 inline mr-1"></i>Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                                <p class="text-xs text-gray-600">
                                    Halaman <span class="font-semibold"><?php echo $page ?? 1; ?></span> dari <span class="font-semibold"><?php echo $totalPages; ?></span>
                                </p>
                                <div class="flex gap-2">
                                    <?php if (($page ?? 1) > 1): ?>
                                        <a href="./index.php?action=reports&page=<?php echo ($page ?? 1) - 1; ?><?php echo !empty($status_filter) ? '&status=' . urlencode($status_filter) : ''; ?><?php echo !empty($reason_filter) ? '&reason=' . urlencode($reason_filter) : ''; ?><?php echo !empty($kategori_filter) ? '&kategori=' . urlencode($kategori_filter) : ''; ?>" class="px-3 py-1.5 text-xs font-medium border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                            Sebelumnya
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (($page ?? 1) < $totalPages): ?>
                                        <a href="./index.php?action=reports&page=<?php echo ($page ?? 1) + 1; ?><?php echo !empty($status_filter) ? '&status=' . urlencode($status_filter) : ''; ?><?php echo !empty($reason_filter) ? '&reason=' . urlencode($reason_filter) : ''; ?><?php echo !empty($kategori_filter) ? '&kategori=' . urlencode($kategori_filter) : ''; ?>" class="px-3 py-1.5 text-xs font-medium bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                            Selanjutnya
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="px-6 py-16 text-center">
                            <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak Ada Laporan</h3>
                            <p class="text-gray-600 text-sm">Tidak ada laporan yang sesuai dengan filter Anda.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Report Detail Modal -->
    <div id="report-detail-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-2xl shadow-2xl max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Detail Laporan</h3>
                <button type="button" onclick="closeReportDetail()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div id="report-detail-content" class="space-y-6">
                <!-- Loading state -->
                <div class="text-center py-8">
                    <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                </div>
            </div>

            <div class="mt-8 flex gap-3 pt-6 border-t border-gray-200">
                <button 
                    type="button"
                    onclick="closeReportDetail()"
                    class="flex-1 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs"
                >
                    Tutup
                </button>
                <button 
                    type="button"
                    id="update-status-btn"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition-all uppercase tracking-widest text-xs shadow-lg shadow-blue-200"
                    onclick="updateReportStatus()"
                >
                    Update Status
                </button>
            </div>
        </div>
    </div>

    <script>
        // Open report detail modal
        function openReportDetail(reportId) {
            const modal = document.getElementById('report-detail-modal');
            const content = document.getElementById('report-detail-content');
            
            console.log('🔍 [MODAL] Opening report detail...');
            console.log('🔍 [MODAL] Report ID:', reportId);
            console.log('🔍 [MODAL] Fetch URL:', `./api/get-report-detail.php?id=${reportId}`);
            
            modal.classList.remove('hidden');
            
            // Fetch report detail
            fetch(`./api/get-report-detail.php?id=${reportId}`)
                .then(res => {
                    console.log('📡 [MODAL] Response Status:', res.status);
                    console.log('📡 [MODAL] Response OK:', res.ok);
                    return res.json();
                })
                .then(data => {
                    console.log('📦 [MODAL] Parsed JSON Response:', JSON.stringify(data, null, 2));
                    if (data.success) {
                        console.log('✅ [MODAL] Success! Data received');
                        const report = data.data;
                        console.log('📋 [MODAL] Report Object:', JSON.stringify(report, null, 2));
                        content.innerHTML = `
                            <div class="space-y-4">
                                <!-- Aspirasi Information -->
                                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-blue-900 mb-2">Aspirasi Dilaporkan</p>
                                    <h4 class="font-semibold text-gray-900">${report.judul}</h4>
                                    <p class="text-sm text-gray-600 mt-2">${report.deskripsi}</p>
                                    <div class="flex gap-2 mt-3">
                                        <span class="px-2 py-1 bg-white rounded text-xs font-medium text-gray-700">#${report.id_aspirasi}</span>
                                        <span class="px-2 py-1 bg-white rounded text-xs font-medium text-gray-700">${report.kategori}</span>
                                    </div>
                                </div>

                                <!-- Report Information -->
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Info Laporan</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">ID Laporan:</span>
                                            <span class="font-medium text-gray-900">#${report.id_report}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Alasan:</span>
                                            <span class="font-medium text-gray-900">${report.reason}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status Saat Ini:</span>
                                            <span class="font-medium text-gray-900">${report.status}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Dibuat:</span>
                                            <span class="font-medium text-gray-900">${new Date(report.created_at).toLocaleString('id-ID')}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reporter Message -->
                                ${report.message ? `
                                    <div>
                                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Pesan Pelapor</p>
                                        <p class="text-sm text-gray-600 p-3 bg-gray-50 rounded-lg border border-gray-200">${report.message}</p>
                                    </div>
                                ` : ''}

                                <!-- Update Status Form -->
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Update Status</p>
                                    <select id="new-status-select" class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="pending" ${report.status === 'pending' ? 'selected' : ''}>Pending</option>
                                        <option value="confirmed" ${report.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                        <option value="processing" ${report.status === 'processing' ? 'selected' : ''}>Processing</option>
                                        <option value="resolved" ${report.status === 'resolved' ? 'selected' : ''}>Resolved</option>
                                        <option value="dismissed" ${report.status === 'dismissed' ? 'selected' : ''}>Dismissed</option>
                                    </select>
                                </div>
                            </div>
                        `;
                        window.currentReportId = reportId;
                    } else {
                        console.error('❌ [MODAL] API returned error:', data.message);
                        content.innerHTML = '<p class="text-red-600">Error: ' + (data.message || 'Unknown error') + '</p>';
                    }
                })
                .catch(err => {
                    console.error('❌ [MODAL] Fetch Error:', err);
                    console.error('❌ [MODAL] Error Stack:', err.stack);
                    console.error('❌ [MODAL] Error Message:', err.message);
                    content.innerHTML = '<p class="text-red-600">Error loading report detail: ' + err.message + '</p>';
                });
        }

        // Close report detail modal
        function closeReportDetail() {
            const modal = document.getElementById('report-detail-modal');
            modal.classList.add('hidden');
        }

        // Update report status
        async function updateReportStatus() {
            const newStatus = document.getElementById('new-status-select')?.value;
            
            if (!newStatus || !window.currentReportId) {
                alert('Error: Missing data');
                return;
            }

            try {
                const response = await fetch('./api/update-report-status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id_report: window.currentReportId,
                        status: newStatus
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Status berhasil diperbarui!');
                    closeReportDetail();
                    location.reload();
                } else {
                    alert('❌ Error: ' + (result.message || 'Gagal update status'));
                }
            } catch (error) {
                console.error(error);
                alert('❌ Terjadi kesalahan');
            }
        }

        // Close modal when clicking outside
        document.getElementById('report-detail-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportDetail();
            }
        });

        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>