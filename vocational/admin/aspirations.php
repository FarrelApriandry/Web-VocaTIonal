<?php
// vocational/admin/aspirations.php

ini_set('display_errors', '0');
error_reporting(E_ALL);

session_start();

// Auth check
require_once __DIR__ . '/../app/Controllers/AdminAuth.php';
require_once __DIR__ . '/../app/Models/Aspirasi.php';
require_once __DIR__ . '/../app/Config/Database.php';

if (!AdminAuth::check()) {
    header('Location: ./auth/login.php');
    exit;
}

$admin = AdminAuth::user();
$aspirasi = new Aspirasi();
$pdo = Database::getConnection();

// Get filters from query parameters
$status_filter = $_GET['status'] ?? '';
$kategori_filter = $_GET['kategori'] ?? '';
$search = $_GET['search'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 20;
$offset = ($page - 1) * $limit;

// Build query
$query = "SELECT * FROM aspirasi WHERE 1=1";
$params = [];

if (!empty($status_filter)) {
    $query .= " AND status = ?";
    $params[] = $status_filter;
}

if (!empty($kategori_filter)) {
    $query .= " AND kategori = ?";
    $params[] = $kategori_filter;
}

if (!empty($search)) {
    $query .= " AND (judul LIKE ? OR deskripsi LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Count total
$countQuery = "SELECT COUNT(*) as total FROM aspirasi WHERE 1=1";
if (!empty($status_filter)) $countQuery .= " AND status = ?";
if (!empty($kategori_filter)) $countQuery .= " AND kategori = ?";
if (!empty($search)) $countQuery .= " AND (judul LIKE ? OR deskripsi LIKE ?)";

$countStmt = $pdo->prepare($countQuery);
$countStmt->execute($params);
$totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalPages = ceil($totalCount / $limit);

// Get aspirasi
$query .= " ORDER BY created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$allAspirations = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

// Get stats
$statsQuery = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses_count,
    SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as selesai_count
FROM aspirasi";
$statsStmt = $pdo->prepare($statsQuery);
$statsStmt->execute();
$stats = $statsStmt->fetch(PDO::FETCH_ASSOC);

$currentPage = 'aspirations';
$title = "VocaTIonal | Kelola Aspirasi";
?>
<?php include __DIR__ . '/components/Header.php'; ?>
<body class="bg-gray-50">
    <div class="md:flex min-h-screen">
        <?php include __DIR__ . '/components/Sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-6 md:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button class="md:hidden text-gray-700 hover:text-gray-900" onclick="toggleSidebar()">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">Kelola Aspirasi</h1>
                            <p class="text-xs text-gray-500">Total: <?php echo $totalCount; ?> aspirasi</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 px-6 md:px-8 py-8 overflow-auto">
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1"><?php echo $stats['total'] ?? 0; ?></p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase">Pending</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1"><?php echo $stats['pending_count'] ?? 0; ?></p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase">Proses</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1"><?php echo $stats['proses_count'] ?? 0; ?></p>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <p class="text-xs font-medium text-gray-500 uppercase">Selesai</p>
                        <p class="text-2xl font-bold text-emerald-600 mt-1"><?php echo $stats['selesai_count'] ?? 0; ?></p>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                    <form method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">Cari Judul/Deskripsi</label>
                                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                                    placeholder="Search..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-600">
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-600">
                                    <option value="">Semua Status</option>
                                    <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Proses" <?php echo $status_filter === 'Proses' ? 'selected' : ''; ?>>Proses</option>
                                    <option value="Selesai" <?php echo $status_filter === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </div>

                            <!-- Kategori Filter -->
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">Kategori</label>
                                <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-600">
                                    <option value="">Semua Kategori</option>
                                    <option value="Akademik" <?php echo $kategori_filter === 'Akademik' ? 'selected' : ''; ?>>Akademik</option>
                                    <option value="Fasilitas" <?php echo $kategori_filter === 'Fasilitas' ? 'selected' : ''; ?>>Fasilitas</option>
                                    <option value="Sarpras" <?php echo $kategori_filter === 'Sarpras' ? 'selected' : ''; ?>>Sarpras</option>
                                    <option value="Layanan" <?php echo $kategori_filter === 'Layanan' ? 'selected' : ''; ?>>Layanan</option>
                                    <option value="UKT" <?php echo $kategori_filter === 'UKT' ? 'selected' : ''; ?>>UKT</option>
                                    <option value="Lainnya" <?php echo $kategori_filter === 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                </select>
                            </div>

                            <!-- Search Button -->
                            <div class="flex items-end gap-2">
                                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    Filter
                                </button>
                                <a href="./aspirations.php" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Aspirasi Table -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <?php if (count($allAspirations) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kategori</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($allAspirations as $asp): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">#<?php echo $asp['id_aspirasi']; ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="<?php echo htmlspecialchars($asp['judul']); ?>">
                                                <?php echo htmlspecialchars(substr($asp['judul'], 0, 50)); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded">
                                                    <?php echo htmlspecialchars($asp['kategori']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <?php 
                                                $statusColor = $asp['status'] === 'Pending' ? 'amber' : ($asp['status'] === 'Proses' ? 'blue' : 'emerald');
                                                ?>
                                                <span class="px-2 py-1 text-xs font-medium bg-<?php echo $statusColor; ?>-100 text-<?php echo $statusColor; ?>-700 rounded">
                                                    <?php echo htmlspecialchars($asp['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                <?php echo date('d M Y', strtotime($asp['created_at'])); ?>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <button onclick="viewAspirationModal(<?php echo $asp['id_aspirasi']; ?>, '<?php echo htmlspecialchars($asp['judul'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($asp['deskripsi'], ENT_QUOTES); ?>', '<?php echo $asp['status']; ?>', '<?php echo $asp['kategori']; ?>', '<?php echo $asp['anonim']; ?>')"
                                                    class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                                    Lihat
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
                                <div class="text-sm text-gray-600">
                                    Halaman <?php echo $page; ?> dari <?php echo $totalPages; ?>
                                </div>
                                <div class="flex gap-2">
                                    <?php if ($page > 1): ?>
                                        <a href="?page=<?php echo $page - 1; ?>&status=<?php echo urlencode($status_filter); ?>&kategori=<?php echo urlencode($kategori_filter); ?>&search=<?php echo urlencode($search); ?>" 
                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                                            Sebelumnya
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($page < $totalPages): ?>
                                        <a href="?page=<?php echo $page + 1; ?>&status=<?php echo urlencode($status_filter); ?>&kategori=<?php echo urlencode($kategori_filter); ?>&search=<?php echo urlencode($search); ?>" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                            Selanjutnya
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="px-6 py-12 text-center">
                            <i data-lucide="inbox" class="w-10 h-10 text-gray-300 mx-auto mb-3"></i>
                            <p class="text-gray-500 text-sm font-medium">Tidak ada aspirasi ditemukan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-6 max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-gray-900"></h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Judul -->
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-2">Judul</label>
                    <p id="modal-judul" class="text-gray-900 font-medium"></p>
                </div>

                <!-- Kategori & Status -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700 block mb-2">Kategori</label>
                        <p id="modal-kategori" class="text-gray-900"></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 block mb-2">Status Saat Ini</label>
                        <p id="modal-status" class="text-gray-900"></p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-2">Deskripsi</label>
                    <p id="modal-deskripsi" class="text-gray-600 text-sm leading-relaxed"></p>
                </div>

                <!-- Anonim Info -->
                <div>
                    <p class="text-sm text-gray-600">
                        <span id="modal-anonim-badge" class="inline-block px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded"></span>
                    </p>
                </div>

                <!-- Update Status -->
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-2">Update Status</label>
                    <div class="flex gap-2">
                        <select id="modal-status-select" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-600">
                            <option value="Pending">Pending</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                        <button onclick="updateAspirationStatus()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeDetailModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentAspirationId = null;

        function viewAspirationModal(id, judul, deskripsi, status, kategori, anonim) {
            currentAspirationId = id;
            
            document.getElementById('modal-title').textContent = `Aspirasi #${id}`;
            document.getElementById('modal-judul').textContent = judul;
            document.getElementById('modal-deskripsi').textContent = deskripsi;
            document.getElementById('modal-kategori').textContent = kategori;
            document.getElementById('modal-status').textContent = status;
            document.getElementById('modal-status-select').value = status;
            document.getElementById('modal-anonim-badge').textContent = anonim == 1 ? 'Anonim' : 'Tidak Anonim';
            
            document.getElementById('detail-modal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
            currentAspirationId = null;
        }

        function updateAspirationStatus() {
            const newStatus = document.getElementById('modal-status-select').value;
            
            if (!newStatus || !currentAspirationId) {
                alert('Data tidak lengkap');
                return;
            }

            // Send update request
            fetch('./api/update-aspirasi-status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_aspirasi: currentAspirationId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status berhasil diupdate!');
                    closeDetailModal();
                    // Refresh page to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    alert('Error: ' + (data.message || 'Gagal update status'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat update status');
            });
        }

        // Initialize lucide icons
        lucide.createIcons();
    </script>
</body>
</html>