<?php
// vocational/app/Views/Components/ShowBoardToggle.php
?>

<label class="flex items-center cursor-pointer group self-start">
    <div class="relative">
        <input type="checkbox" data-show-board class="sr-only">
        <div id="board-toggle-bg" class="block bg-gray-300 w-12 h-7 md:w-14 md:h-8 rounded-full transition-colors duration-200"></div>
        <div id="board-toggle-dot" class="absolute left-1 top-1 bg-white w-5 h-5 md:w-6 md:h-6 rounded-full shadow-sm transition-transform duration-200"></div>
    </div>
    <span class="ml-3 text-gray-700 font-semibold text-sm md:text-base">Tampil di Papan Buletin</span>
</label>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.querySelector('input[data-show-board]');
        var bg  = document.getElementById('board-toggle-bg');
        var dot = document.getElementById('board-toggle-dot');
        if (!toggle || !bg || !dot) return;

        function updateToggle() {
            if (toggle.checked) {
                bg.classList.remove('bg-gray-300');
                bg.classList.add('bg-blue-900');
                dot.style.transform = 'translateX(20px)';
            } else {
                bg.classList.remove('bg-blue-900');
                bg.classList.add('bg-gray-300');
                dot.style.transform = 'translateX(0)';
            }
        }

        toggle.addEventListener('change', updateToggle);
        updateToggle();
    });
</script>
