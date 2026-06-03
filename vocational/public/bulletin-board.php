<?php 
session_start();

$title = "VocaTIonal | Papan Buletin";
$active = "papan-buletin";

$publicDir = dirname(__FILE__);
$appDir = dirname($publicDir) . '/app';

require_once $appDir . '/Controllers/Auth.php';
$auth = new Auth();
$isLoggedIn = $auth->check();

if (!$isLoggedIn) {
    header('Location: ./');
    exit;
}

$user = $auth->user();

include $appDir . '/Views/Components/Header.php';
include $appDir . '/Views/Components/Navbar.php';
?>

<main id="main-content" class="mx-auto px-4 md:px-8 py-8 md:py-16 max-w-7xl">
    <header class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Papan <span class="text-blue-900">Buletin</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-600">
            Aspirasi dari sesama mahasiswa yang telah disetujui untuk ditampilkan
        </p>
    </header>

    <!-- Category Filter -->
    <nav aria-label="Filter kategori" class="mb-8">
        <div class="flex flex-wrap gap-3 md:gap-4" role="radiogroup" aria-label="Pilih kategori">
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-blue-900 text-white rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="all" role="radio" aria-checked="true">
                Semua
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="Akademik" role="radio" aria-checked="false">
                Akademik
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="Fasilitas" role="radio" aria-checked="false">
                Fasilitas
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="Sarpras" role="radio" aria-checked="false">
                Sarpras
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="Layanan" role="radio" aria-checked="false">
                Layanan
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="UKT" role="radio" aria-checked="false">
                UKT
            </button>
            <button class="category-filter px-6 py-2 border-gray-200 border-2 border-solid bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                    data-category="Lainnya" role="radio" aria-checked="false">
                Lainnya
            </button>
        </div>
    </nav>

    <!-- Status announcement for screen readers -->
    <div id="board-status" aria-live="polite" aria-atomic="true" class="sr-only"></div>

    <!-- Board Container -->
    <section aria-label="Daftar aspirasi" id="board-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php for ($i = 0; $i < 9; $i++): ?>
            <div class="h-64 bg-gray-200 rounded-lg animate-pulse" aria-hidden="true"></div>
        <?php endfor; ?>
    </section>

    <!-- Load more -->
    <div class="flex justify-center">
        <button id="load-more-btn" class="px-8 py-3 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition-colors hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2">
            Muat Selengkapnya
        </button>
    </div>

    <!-- Empty state -->
    <div id="empty-state" class="hidden text-center py-16" role="status">
        <i data-lucide="inbox" aria-hidden="true" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Aspirasi</h2>
        <p class="text-gray-600">Belum ada aspirasi yang ditampilkan di papan buletin untuk kategori ini</p>
    </div>
</main>

<?php include __DIR__ . '/../app/Views/Components/ReportModal.php'; ?>
<?php include __DIR__ . '/../app/Views/Components/ConfirmationModal.php'; ?>
<script src="./js/confirmation-modal.js"></script>

<!-- Detail Modal -->
<div id="detail-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm hidden" role="dialog" aria-modal="true" aria-labelledby="detail-modal-title">
    <div class="bg-white rounded-2xl p-6 md:p-8 w-[90%] max-w-lg shadow-2xl max-h-[80vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <span id="detail-modal-kategori" class="inline-block px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-bold uppercase tracking-wider"></span>
            <button id="detail-modal-close" type="button" aria-label="Tutup detail" class="text-gray-500 hover:text-gray-900 p-2 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                <i data-lucide="x" aria-hidden="true" class="w-5 h-5"></i>
            </button>
        </div>
        <h2 id="detail-modal-title" class="text-lg font-bold text-gray-900 mb-2"></h2>
        <time id="detail-modal-date" class="text-xs text-gray-600 block mb-4"></time>
        <p id="detail-modal-desc" class="text-sm text-gray-700 leading-relaxed whitespace-pre-line"></p>
        <div class="mt-6 pt-4 border-t border-gray-200 flex items-center gap-2">
            <span id="detail-modal-reactions" class="text-sm font-semibold text-gray-700"></span>
        </div>
    </div>
</div>


<script>
    let currentCategory = 'all';
    let currentPage = 1;
    const limit = 12;
    let isLoading = false;
    let loadedAspirations = [];

    // Detail modal logic
    function openDetailModal(aspiration) {
        const modal = document.getElementById('detail-modal');
        document.getElementById('detail-modal-title').textContent = aspiration.judul;
        document.getElementById('detail-modal-kategori').textContent = aspiration.kategori;
        document.getElementById('detail-modal-date').textContent = new Date(aspiration.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('detail-modal-desc').textContent = aspiration.deskripsi;
        document.getElementById('detail-modal-reactions').innerHTML = '<i data-lucide="thumbs-up" class="w-4 h-4 inline-block"></i> ' + aspiration.total_reactions + ' reaksi';
        modal.classList.remove('hidden');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    document.getElementById('detail-modal-close').addEventListener('click', function() {
        document.getElementById('detail-modal').classList.add('hidden');
    });
    document.getElementById('detail-modal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('detail-modal').classList.contains('hidden')) {
            document.getElementById('detail-modal').classList.add('hidden');
        }
    });

    async function loadAspirations(category = 'all', page = 1, append = false) {
        if (isLoading) return;
        isLoading = true;

        const boardContainer = document.getElementById('board-container');
        const emptyState = document.getElementById('empty-state');
        const loadMoreBtn = document.getElementById('load-more-btn');
        const statusEl = document.getElementById('board-status');

        if (page === 1 && !append) {
            boardContainer.innerHTML = '';
            for (let i = 0; i < 9; i++) {
                boardContainer.innerHTML += '<div class="h-64 bg-gray-200 rounded-lg animate-pulse" aria-hidden="true"></div>';
            }
            statusEl.textContent = 'Memuat aspirasi...';
        }

        try {
            const response = await fetch(`./api/board/aspirations.php?category=${encodeURIComponent(category)}&page=${page}`);
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                if (page === 1) { loadedAspirations = result.data; }
                else { loadedAspirations = loadedAspirations.concat(result.data); }
                let html = '';
                result.data.forEach(aspiration => {
                    const categoryColors = {
                        'Akademik': 'bg-blue-100 border-blue-300 text-blue-900',
                        'Fasilitas': 'bg-orange-100 border-orange-300 text-orange-900',
                        'Sarpras': 'bg-red-100 border-red-300 text-red-900',
                        'Layanan': 'bg-cyan-100 border-cyan-300 text-cyan-900',
                        'UKT': 'bg-green-100 border-green-300 text-green-900',
                        'Lainnya': 'bg-purple-100 border-purple-300 text-purple-900'
                    };
                    const color = categoryColors[aspiration.kategori] || 'bg-gray-100 border-gray-300 text-gray-900';

                    html += `
                        <article class="board-card rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden"
                                 data-aspiration-id="${aspiration.id_aspirasi}"
                                 aria-label="Aspirasi: ${aspiration.judul.replace(/"/g, '&quot;')}">
                            <div class="${color} p-6 min-h-[240px] flex flex-col justify-between border-2 relative">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-block px-3 py-1 bg-white bg-opacity-70 rounded-full text-xs font-bold uppercase tracking-wider">
                                        ${aspiration.kategori}
                                    </span>
                                    <time class="text-xs text-gray-700" datetime="${aspiration.created_at}">
                                        ${new Date(aspiration.created_at).toLocaleDateString('id-ID')}
                                    </time>
                                </div>
                                <div class="mb-3">
                                    <h3 class="font-bold text-base leading-tight line-clamp-2">${aspiration.judul}</h3>
                                </div>
                                <p class="text-sm leading-relaxed mb-4 line-clamp-3 opacity-90">${aspiration.excerpt}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-current border-opacity-20">
                                    <span class="text-sm font-semibold flex items-center gap-1" aria-label="${aspiration.total_reactions} reaksi">
                                        <i data-lucide="thumbs-up" aria-hidden="true" class="w-4 h-4"></i> ${aspiration.total_reactions}
                                    </span>
                                    <div class="flex gap-3">
                                        <button class="btn-view-detail px-3 py-1 bg-white bg-opacity-70 hover:bg-opacity-100 rounded text-xs font-bold transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900"
                                                data-aspiration-id="${aspiration.id_aspirasi}"
                                                aria-label="Lihat detail aspirasi: ${aspiration.judul.replace(/"/g, '&quot;')}">
                                            Selengkapnya
                                        </button>
                                        ${window.isLoggedIn ? `
                                            <button class="btn-react p-2 min-w-[44px] min-h-[44px] flex items-center justify-center bg-white bg-opacity-70 hover:bg-opacity-100 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-900"
                                                    data-aspiration-id="${aspiration.id_aspirasi}"
                                                    aria-pressed="${aspiration.userHasReacted ? 'true' : 'false'}"
                                                    aria-label="Suka aspirasi ini">
                                                <i data-lucide="${aspiration.userHasReacted ? 'thumbs-up' : 'heart'}" class="w-4 h-4"></i>
                                            </button>
                                            <button class="btn-report p-2 min-w-[44px] min-h-[44px] flex items-center justify-center bg-white bg-opacity-70 hover:bg-opacity-100 rounded-xl transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                                                    data-aspiration-id="${aspiration.id_aspirasi}"
                                                    data-aspiration-title="${aspiration.judul.replace(/"/g, '&quot;')}"
                                                    data-aspiration-description="${aspiration.deskripsi.replace(/"/g, '&quot;')}"
                                                    aria-label="Laporkan aspirasi ini">
                                                <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                                            </button>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </article>
                    `;
                });

                if (page === 1) { boardContainer.innerHTML = html; }
                else { boardContainer.innerHTML += html; }

                attachEventListeners();
                statusEl.textContent = `${result.data.length} aspirasi dimuat`;

                if (result.pagination.hasNextPage) { loadMoreBtn.classList.remove('hidden'); }
                else { loadMoreBtn.classList.add('hidden'); }

                emptyState.classList.add('hidden');
            } else if (page === 1) {
                boardContainer.innerHTML = '';
                emptyState.classList.remove('hidden');
                loadMoreBtn.classList.add('hidden');
                statusEl.textContent = 'Tidak ada aspirasi ditemukan';
            }
        } catch (error) {
            console.error('Error loading aspirations:', error);
            if (page === 1) {
                boardContainer.innerHTML = '<p class="col-span-full text-center text-red-600" role="alert">Error memuat aspirasi. Silakan coba lagi.</p>';
            }
            statusEl.textContent = 'Gagal memuat aspirasi';
        }
        isLoading = false;
    }

    function attachEventListeners() {
        // Detail button
        document.querySelectorAll('.btn-view-detail').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('article');
                const id = this.dataset.aspirationId;
                const aspData = loadedAspirations.find(a => a.id_aspirasi == id);
                if (aspData) openDetailModal(aspData);
            });
        });

        document.querySelectorAll('.btn-react').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.dataset.aspirationId;
                const card = this.closest('article');
                const countSpan = card.querySelector('[aria-label$="reaksi"]');

                // --- OPTIMISTIC UI: Simpan state sebelumnya untuk rollback ---
                const prevPressed = this.getAttribute('aria-pressed') === 'true';
                const prevCountText = countSpan.textContent.trim();
                const prevCount = parseInt(prevCountText) || 0;

                // Hitung state baru secara optimistik
                const newPressed = !prevPressed;
                const newCount = newPressed ? prevCount + 1 : prevCount - 1;

                // Update UI secara optimistik
                this.innerHTML = `<i data-lucide="${newPressed ? 'thumbs-up' : 'heart'}" class="w-4 h-4"></i>`;
                this.setAttribute('aria-pressed', String(newPressed));
                countSpan.innerHTML = `<i data-lucide="thumbs-up" class="w-4 h-4"></i> ${newCount}`;
                countSpan.setAttribute('aria-label', `${newCount} reaksi`);
                if (typeof lucide !== 'undefined') lucide.createIcons();

                // --- ANIMASI: bounce effect pada tombol ---
                this.classList.remove('btn-react-bounce');
                // Force reflow biar animasi bisa diputer ulang
                void this.offsetWidth;
                this.classList.add('btn-react-bounce');

                // --- ANIMASI: efek particle pada counter ---
                countSpan.classList.remove('counter-pop');
                void countSpan.offsetWidth;
                countSpan.classList.add('counter-pop');

                try {
                    const response = await fetch('./api/board/react.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_aspirasi: id })
                    });
                    const result = await response.json();

                    if (!result.success) {
                        // ROLLBACK jika gagal
                        throw new Error(result.message || 'Request failed');
                    }

                    // Sync dengan data real dari server (untuk jaga-jaga kalau ada perbedaan count)
                    const realReacted = result.data.userHasReacted;
                    const realCount = result.data.totalReactions;
                    if (realReacted !== newPressed || realCount !== newCount) {
                        this.innerHTML = `<i data-lucide="${realReacted ? 'thumbs-up' : 'heart'}" class="w-4 h-4"></i>`;
                        this.setAttribute('aria-pressed', String(realReacted));
                        countSpan.innerHTML = `<i data-lucide="thumbs-up" class="w-4 h-4"></i> ${realCount}`;
                        countSpan.setAttribute('aria-label', `${realCount} reaksi`);
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                } catch (error) {
                    console.error('React error:', error);
                    // ROLLBACK ke state sebelumnya
                    this.innerHTML = `<i data-lucide="${prevPressed ? 'thumbs-up' : 'heart'}" class="w-4 h-4"></i>`;
                    this.setAttribute('aria-pressed', String(prevPressed));
                    countSpan.innerHTML = `<i data-lucide="thumbs-up" class="w-4 h-4"></i> ${prevCount}`;
                    countSpan.setAttribute('aria-label', `${prevCount} reaksi`);
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                    
                    // --- ANIMASI ERROR: shake effect ---
                    this.classList.add('btn-react-error');
                    setTimeout(() => this.classList.remove('btn-react-error'), 400);
                }
            });
        });

        document.querySelectorAll('.btn-report').forEach(btn => {
            btn.addEventListener('click', function() {
                openReportModal(this.dataset.aspirationId, this.dataset.aspirationTitle, this.dataset.aspirationDescription);
            });
        });

        lucide.createIcons();
    }

    // Category filter with aria-checked
    document.querySelectorAll('.category-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-filter').forEach(b => {
                b.classList.remove('bg-blue-900', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-900', 'hover:bg-gray-200', 'border-gray-200');
                b.setAttribute('aria-checked', 'false');
            });
            this.classList.add('bg-blue-900', 'text-white');
            this.classList.remove('bg-gray-100', 'text-gray-900', 'hover:bg-gray-200', 'border-gray-200');
            this.setAttribute('aria-checked', 'true');
            
            currentCategory = this.dataset.category;
            currentPage = 1;
            loadAspirations(currentCategory, 1);
        });
    });

    document.getElementById('load-more-btn').addEventListener('click', function() {
        currentPage++;
        loadAspirations(currentCategory, currentPage, true);
    });

    window.isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    loadAspirations();
</script>

<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    @keyframes fadeInScale { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    .board-card { animation: fadeInScale 0.5s ease-out forwards; }

    /* --- Animasi Reaksi --- */
    @keyframes btnBounce {
        0%   { transform: scale(1); }
        30%  { transform: scale(1.3); }
        50%  { transform: scale(0.9); }
        70%  { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    @keyframes counterPop {
        0%   { transform: scale(1); }
        50%  { transform: scale(1.2); color: #2563eb; }
        100% { transform: scale(1); }
    }
    @keyframes btnShake {
        0%, 100% { transform: translateX(0); }
        20%      { transform: translateX(-6px); }
        40%      { transform: translateX(6px); }
        60%      { transform: translateX(-4px); }
        80%      { transform: translateX(4px); }
    }

    .btn-react svg {
        transition: all 0.2s ease;
    }
    /* Saat tombol udah di-like → icon jadi FILL */
    .btn-react[aria-pressed="true"] svg {
        fill: currentColor;
        stroke-width: 1px;
    }

    .btn-react-bounce {
        animation: btnBounce 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
    }
    .counter-pop {
        animation: counterPop 0.3s ease-out !important;
    }
    .btn-react-error {
        animation: btnShake 0.4s ease-in-out !important;
        background-color: rgba(239, 68, 68, 0.3) !important;
    }
</style>
</body>
</html>
