<div id="modal-confirm" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-lg shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="modal-box">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Konfirmasi Aspirasi</h3>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <div class="space-y-4 text-left mb-8">
            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                <p class="text-[10px] uppercase tracking-widest font-bold text-blue-900 mb-1">Kategori</p>
                <p id="confirm-kategori" class="font-semibold text-gray-800">-</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-1">Subjek</p>
                <p id="confirm-subjek" class="font-medium text-gray-900 text-lg">-</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-1">Detail Laporan</p>
                <p id="confirm-detail" class="text-sm text-gray-600 leading-relaxed italic">"-"</p>
            </div>
            <div id="confirm-img-wrapper" class="hidden">
                 <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Lampiran Bukti</p>
                 <img id="confirm-preview" src="" class="w-full h-40 object-cover rounded-xl border border-gray-200">
            </div>
            <div id="confirm-anonim-status" class="flex items-center gap-2 text-xs font-bold text-green-600">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                KIRIM SEBAGAI ANONIM
            </div>
            <div id="confirm-board-status" class="flex items-center gap-2 text-xs font-bold text-purple-600">
                <i data-lucide="message-square" class="w-4 h-4"></i>
                TAMPIL DI PAPAN BULETIN
            </div>
        </div>

        <div class="flex gap-3">
            <button onclick="closeModal()" class="flex-1 py-4 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">
                Cek Lagi
            </button>
            <button id="final-submit" class="flex-1 bg-[#111827] text-white py-4 rounded-xl font-bold hover:bg-black transition-all uppercase tracking-widest text-xs shadow-lg shadow-gray-200">
                Kirim Sekarang
            </button>
        </div>
    </div>
</div>