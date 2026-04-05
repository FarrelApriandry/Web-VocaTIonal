<?php

// vocational/app/Views/Components/BoardAspirationCard.php
// Reusable bulletin board aspiration card component

/**
 * @param array $aspiration - Aspiration data from API
 * @param bool $isLoggedIn - Whether user is logged in
 * @param bool $userHasReacted - Whether current user has reacted
 * @param bool $userHasReported - Whether current user has reported
 */

$categoryColors = [
    'Akademik' => 'bg-blue-100 border-blue-300 text-blue-900',
    'Fasilitas' => 'bg-orange-100 border-orange-300 text-orange-900',
    'UKT' => 'bg-green-100 border-green-300 text-green-900',
    'Lainnya' => 'bg-purple-100 border-purple-300 text-purple-900'
];

$categoryColor = $categoryColors[$aspiration['kategori']] ?? 'bg-gray-100 border-gray-300 text-gray-900';
$rotation = rand(-2, 2);
$randomDelay = rand(0, 10) * 0.05;

?>

<div class="board-card rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden"
     style="transform: rotate(<?= $rotation ?>deg); animation-delay: <?= $randomDelay ?>s;"
     data-aspiration-id="<?= htmlspecialchars($aspiration['id_aspirasi']) ?>">
    
    <!-- Sticky tape effect (top) -->
    <div class="absolute top-0 left-1/4 w-12 h-3 bg-yellow-100 border border-yellow-200 rounded opacity-60 shadow-sm"></div>
    <div class="absolute top-0 right-1/3 w-12 h-3 bg-yellow-100 border border-yellow-200 rounded opacity-60 shadow-sm"></div>

    <!-- Card content -->
    <div class="<?= $categoryColor ?> p-6 min-h-[240px] flex flex-col justify-between border-2 relative">
        
        <!-- Category badge -->
        <div class="flex items-center justify-between mb-3">
            <span class="inline-block px-3 py-1 bg-white bg-opacity-70 rounded-full text-xs font-bold uppercase tracking-wider">
                <?= htmlspecialchars($aspiration['kategori']) ?>
            </span>
            <span class="text-xs text-gray-600">
                <?= date('d M Y', strtotime($aspiration['created_at'])) ?>
            </span>
        </div>

        <!-- Title -->
        <div class="mb-3">
            <h3 class="font-bold text-base leading-tight line-clamp-2">
                <?= htmlspecialchars($aspiration['judul']) ?>
            </h3>
        </div>

        <!-- Excerpt -->
        <p class="text-sm leading-relaxed mb-4 line-clamp-3 opacity-90">
            <?= htmlspecialchars($aspiration['excerpt']) ?>
        </p>

        <!-- Footer: Reactions & Actions -->
        <div class="flex items-center justify-between pt-3 border-t border-current border-opacity-20">
            
            <!-- Reaction count -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold">
                    👍 <?= intval($aspiration['total_reactions']) ?>
                </span>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <!-- View detail button -->
                <button class="btn-view-detail px-3 py-1 bg-white bg-opacity-70 hover:bg-opacity-100 rounded text-xs font-bold transition-all"
                        data-aspiration-id="<?= htmlspecialchars($aspiration['id_aspirasi']) ?>">
                    Selengkapnya
                </button>

                <!-- Like button (only if logged in) -->
                <?php if ($isLoggedIn): ?>
                    <button class="btn-react px-2 py-1 bg-white bg-opacity-70 hover:bg-opacity-100 rounded text-xs font-bold transition-all"
                            data-aspiration-id="<?= htmlspecialchars($aspiration['id_aspirasi']) ?>"
                            title="Like">
                        <?= $userHasReacted ? '👍' : '🤍' ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .board-card {
        animation: fadeInScale 0.5s ease-out forwards;
    }

    .board-card:hover {
        transform: translateY(-4px) !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Dynamic animation for each card
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.board-card').forEach(card => {
            const rotation = Math.random() * 4 - 2; // -2 to 2 degrees
            card.style.setProperty('--rotation', rotation + 'deg');
            card.style.setProperty('--delay', (Math.random() * 0.5) + 's');
        });
    });
</script>
