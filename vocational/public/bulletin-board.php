<?php 
// START SESSION
session_start();

// Props
$title = "VocaTIonal | Papan Buletin";
$active = "papan-buletin";

// Import components
include __DIR__ . '/../app/Views/Components/Header.php';
include __DIR__ . '/../app/Views/Components/Navbar.php';

// Check auth
require_once __DIR__ . '/../app/Controllers/Auth.php';
$auth = new Auth();
$isLoggedIn = $auth->check();
$user = $isLoggedIn ? $auth->user() : null;
?>

<main class="mx-auto px-6 md:px-16 py-8 md:py-16">
    <!-- Header -->
    <header class="mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Papan <span class="text-blue-900">Buletin</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-500">
            Aspirasi dari sesama mahasiswa yang telah disetujui untuk ditampilkan
        </p>
    </header>

    <!-- Category Filter -->
    <div class="mb-8 flex flex-wrap gap-3 md:gap-4">
        <button class="category-filter px-6 py-2 bg-blue-900 text-white rounded-full font-semibold transition-all active"
                data-category="all">
            Semua
        </button>
        <button class="category-filter px-6 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all"
                data-category="Akademik">
            Akademik
        </button>
        <button class="category-filter px-6 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all"
                data-category="Fasilitas">
            Fasilitas
        </button>
        <button class="category-filter px-6 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all"
                data-category="UKT">
            UKT
        </button>
        <button class="category-filter px-6 py-2 bg-gray-100 text-gray-900 hover:bg-gray-200 rounded-full font-semibold transition-all"
                data-category="Lainnya">
            Lainnya
        </button>
    </div>

    <!-- Board Container (Masonry Grid) -->
    <div id="board-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Skeleton loaders -->
        <?php for ($i = 0; $i < 9; $i++): ?>
            <div class="h-64 bg-gray-200 rounded-lg animate-pulse"></div>
        <?php endfor; ?>
    </div>

    <!-- Load more button -->
    <div class="flex justify-center">
        <button id="load-more-btn" class="px-8 py-3 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition-colors hidden">
            Muat Selengkapnya
        </button>
    </div>

    <!-- Empty state -->
    <div id="empty-state" class="hidden text-center py-16">
        <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Aspirasi</h3>
        <p class="text-gray-600">Belum ada aspirasi yang ditampilkan di papan buletin untuk kategori ini</p>
    </div>
</main>

<?php 
    // Include components
    include __DIR__ . '/../app/Views/Components/ReportModal.php';
?>

<script>
    let currentCategory = 'all';
    let currentPage = 1;
    const limit = 12;
    let isLoading = false;

    // Load aspirations
    async function loadAspirations(category = 'all', page = 1, append = false) {
        if (isLoading) return;
        
        isLoading = true;
        const boardContainer = document.getElementById('board-container');
        const emptyState = document.getElementById('empty-state');
        const loadMoreBtn = document.getElementById('load-more-btn');

        if (page === 1 && !append) {
            boardContainer.innerHTML = '';
            for (let i = 0; i < 9; i++) {
                boardContainer.innerHTML += '<div class="h-64 bg-gray-200 rounded-lg animate-pulse"></div>';
            }
        }

        try {
            const response = await fetch(`./api/board/aspirations.php?category=${encodeURIComponent(category)}&page=${page}`);
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                let html = '';
                
                result.data.forEach(aspiration => {
                    const categoryColors = {
                        'Akademik': 'bg-blue-100 border-blue-300 text-blue-900',
                        'Fasilitas': 'bg-orange-100 border-orange-300 text-orange-900',
                        'UKT': 'bg-green-100 border-green-300 text-green-900',
                        'Lainnya': 'bg-purple-100 border-purple-300 text-purple-900'
                    };

                    const color = categoryColors[aspiration.kategori] || 'bg-gray-100 border-gray-300 text-gray-900';
                    const rotation = Math.random() * 4 - 2;

                    html += `
                        <div class="board-card rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden"
                             style="transform: rotate(${rotation}deg); animation: fadeInScale 0.5s ease-out forwards;"
                             data-aspiration-id="${aspiration.id_aspirasi}">
                            
                            <!-- Sticky tape -->
                            <div class="absolute top-0 left-1/4 w-12 h-3 bg-yellow-100 border border-yellow-200 rounded opacity-60 shadow-sm"></div>
                            <div class="absolute top-0 right-1/3 w-12 h-3 bg-yellow-100 border border-yellow-200 rounded opacity-60 shadow-sm"></div>

                            <!-- Content -->
                            <div class="${color} p-6 min-h-[240px] flex flex-col justify-between border-2 relative">
                                
                                <!-- Category & Date -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-block px-3 py-1 bg-white bg-opacity-70 rounded-full text-xs font-bold uppercase tracking-wider">
                                        ${aspiration.kategori}
                                    </span>
                                    <span class="text-xs text-gray-600">
                                        ${new Date(aspiration.created_at).toLocaleDateString('id-ID')}
                                    </span>
                                </div>

                                <!-- Title -->
                                <div class="mb-3">
                                    <h3 class="font-bold text-base leading-tight line-clamp-2">
                                        ${aspiration.judul}
                                    </h3>
                                </div>

                                <!-- Excerpt -->
                                <p class="text-sm leading-relaxed mb-4 line-clamp-3 opacity-90">
                                    ${aspiration.excerpt}
                                </p>

                                <!-- Footer -->
                                <div class="flex items-center justify-between pt-3 border-t border-current border-opacity-20">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold">👍 ${aspiration.total_reactions}</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="btn-view-detail px-3 py-1 bg-white bg-opacity-70 hover:bg-opacity-100 rounded text-xs font-bold transition-all"
                                                data-aspiration-id="${aspiration.id_aspirasi}">
                                            Selengkapnya
                                        </button>
                                        ${window.isLoggedIn ? `
                                            <button class="btn-react px-2 py-1 bg-white bg-opacity-70 hover:bg-opacity-100 rounded text-xs font-bold transition-all"
                                                    data-aspiration-id="${aspiration.id_aspirasi}"
                                                    title="Like">
                                                ${aspiration.userHasReacted ? '👍' : '🤍'}
                                            </button>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                if (page === 1) {
                    boardContainer.innerHTML = html;
                } else {
                    boardContainer.innerHTML += html;
                }

                // Attach event listeners
                attachEventListeners();

                // Show/hide load more button
                if (result.pagination.hasNextPage) {
                    loadMoreBtn.classList.remove('hidden');
                } else {
                    loadMoreBtn.classList.add('hidden');
                }

                emptyState.classList.add('hidden');
            } else if (page === 1) {
                boardContainer.innerHTML = '';
                emptyState.classList.remove('hidden');
                loadMoreBtn.classList.add('hidden');
            }
        } catch (error) {
            console.error('Error loading aspirations:', error);
            if (page === 1) {
                boardContainer.innerHTML = '<p class="col-span-full text-center text-red-600">Error memuat aspirasi</p>';
            }
        }

        isLoading = false;
    }

    // Attach event listeners
    function attachEventListeners() {
        // Like button
        document.querySelectorAll('.btn-react').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.dataset.aspirationId;
                try {
                    const response = await fetch('./api/board/react.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_aspirasi: id })
                    });
                    const result = await response.json();
                    if (result.success) {
                        this.textContent = result.data.userHasReacted ? '👍' : '🤍';
                        // Find reaction count and update
                        const card = this.closest('.board-card');
                        const countSpan = card.querySelector('.text-sm.font-semibold');
                        countSpan.textContent = `👍 ${result.data.totalReactions}`;
                    }
                } catch (error) {
                    console.error('React error:', error);
                }
            });
        });

        // Report button (if logged in)
        // Will be added in detail modal

        lucide.createIcons();
    }

    // Category filter
    document.querySelectorAll('.category-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-filter').forEach(b => {
                b.classList.remove('bg-blue-900', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-900', 'hover:bg-gray-200');
            });
            this.classList.add('bg-blue-900', 'text-white');
            this.classList.remove('bg-gray-100', 'text-gray-900', 'hover:bg-gray-200');
            
            currentCategory = this.dataset.category;
            currentPage = 1;
            loadAspirations(currentCategory, 1);
        });
    });

    // Load more button
    document.getElementById('load-more-btn').addEventListener('click', function() {
        currentPage++;
        loadAspirations(currentCategory, currentPage, true);
    });

    // Initial load
    window.isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    loadAspirations();
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

</body>
</html>