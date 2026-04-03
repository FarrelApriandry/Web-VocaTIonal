<?php
// vocational/app/Views/Components/ShowBoardToggle.php
// Toggle checkbox for showing aspiration on bulletin board
?>

<label class="flex items-center cursor-pointer group self-start">
    <div class="relative">
        <input type="checkbox" data-show-board class="sr-only">
        <div class="block bg-gray-300 w-12 h-7 md:w-14 md:h-8 rounded-full transition"></div>
        <div class="dot absolute left-1 top-1 bg-white w-5 h-5 md:w-6 md:h-6 rounded-full transition shadow-sm"></div>
    </div>
    <span class="ml-3 text-gray-700 font-semibold text-sm md:text-base">Tampil di Papan Buletin</span>
</label>

<script>
    // Toggle checkbox styling
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('input[data-show-board]');
        if (!toggle) return;

        const parent = toggle.closest('label');
        const bgDiv = parent.querySelector('.block');
        const dotDiv = parent.querySelector('.dot');

        function updateToggle() {
            if (toggle.checked) {
                bgDiv.classList.remove('bg-gray-300');
                bgDiv.classList.add('bg-purple-600');
                dotDiv.classList.remove('left-1');
                dotDiv.classList.add('left-7', 'md:left-8');
            } else {
                bgDiv.classList.add('bg-gray-300');
                bgDiv.classList.remove('bg-purple-600');
                dotDiv.classList.add('left-1');
                dotDiv.classList.remove('left-7', 'md:left-8');
            }
        }

        toggle.addEventListener('change', updateToggle);
        
        // Initialize on load
        updateToggle();
    });
</script>