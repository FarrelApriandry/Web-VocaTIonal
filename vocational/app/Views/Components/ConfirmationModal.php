<!-- @Views/Components/ConfirmationModal.php -->
<!-- Generic Reusable Confirmation Modal Component -->
<div id="confirmation-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-md shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="confirmation-modal-box">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 id="confirmation-title" class="text-xl font-bold text-gray-900">Konfirmasi Aksi</h3>
            <button type="button" onclick="window.confirmationModal.close()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Message -->
        <div class="mb-8">
            <p id="confirmation-message" class="text-gray-600 text-sm md:text-base leading-relaxed">
                Apakah Anda yakin ingin melakukan aksi ini?
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <button id="confirmation-cancel-btn" type="button" onclick="window.confirmationModal.close()" 
                    class="flex-1 py-3 md:py-4 rounded-xl font-bold text-gray-700 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs border border-gray-300">
                Batal
            </button>
            <button id="confirmation-confirm-btn" type="button" onclick="window.confirmationModal.confirm()" 
                    class="flex-1 py-3 md:py-4 rounded-xl font-bold text-white bg-blue-900 hover:bg-blue-800 transition-all uppercase tracking-widest text-xs shadow-lg">
                Konfirmasi
            </button>
        </div>
    </div>
</div>