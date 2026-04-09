<?php
// vocational/app/Views/Components/ReportModal.php
// Report Modal Component for bulletin board aspiration reporting
?>

<!-- Report Modal -->
<div id="report-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 w-full max-w-lg shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="report-modal-box">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Laporkan Aspirasi</h3>
            <button type="button" onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="space-y-4 text-left mb-8">
            <!-- Aspiration Title (Display only) -->
            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                <p class="text-[10px] uppercase tracking-widest font-bold text-blue-900 mb-1">Judul Aspirasi</p>
                <p id="report-aspiration-title" class="font-semibold text-gray-800">-</p>
            </div>

            <!-- Aspiration Description (Display only) -->
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Detail Aspirasi</p>
                <p id="report-aspiration-description" class="text-sm text-gray-600 leading-relaxed italic p-3 bg-gray-50 rounded-xl border border-gray-200">-</p>
            </div>

            <!-- Reason Dropdown -->
            <div>
                <label class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 block">Alasan Laporan <span class="text-red-500">*</span></label>
                <select id="report-reason" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium">
                    <option value="">-- Pilih Alasan --</option>
                    <option value="inappropriate">Konten Tidak Pantas (Inappropriate)</option>
                    <option value="spam">Spam</option>
                    <option value="offensive">Menyerang/Kasar (Offensive)</option>
                </select>
                <p id="report-reason-error" class="hidden text-xs text-red-500 mt-1"></p>
            </div>

            <!-- Message (Optional) -->
            <div>
                <label class="text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 block">Pesan Tambahan (Opsional)</label>
                <textarea 
                    id="report-message"
                    placeholder="Jelaskan alasan laporan Anda..."
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                    rows="4"
                    maxlength="500"
                ></textarea>
                <p class="text-xs text-gray-500 mt-2">
                    <span id="report-message-count">0</span>/500 karakter
                </p>
            </div>

            <!-- Info Box -->
            <div class="flex items-start gap-3 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-xs font-bold text-amber-900 uppercase tracking-widest mb-1">Informasi Penting</p>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        Laporan Anda akan membantu kami menjaga kualitas papan buletin. Data pelapor disimpan untuk verifikasi admin.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex gap-3">
            <button 
                onclick="closeReportModal()"
                class="flex-1 py-4 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs"
            >
                Cek Lagi
            </button>
            <button 
                onclick="submitReport()"
                id="report-submit-btn"
                class="flex-1 bg-[#111827] text-white py-4 rounded-xl font-bold hover:bg-black transition-all uppercase tracking-widest text-xs shadow-lg shadow-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Kirim Laporan
            </button>
        </div>

        <!-- Loading State -->
        <div id="report-loading" class="hidden absolute inset-0 bg-black/20 flex items-center justify-center rounded-3xl">
            <div class="bg-white rounded-full p-3">
                <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Track current aspiration being reported
    let currentReportAspirationId = null;

    /**
     * Open report modal for specific aspiration
     */
    function openReportModal(aspirationId, aspirationTitle, aspirationDescription = '-') {
        currentReportAspirationId = aspirationId;
        document.getElementById('report-aspiration-title').textContent = aspirationTitle;
        document.getElementById('report-aspiration-description').textContent = aspirationDescription;
        document.getElementById('report-reason').value = '';
        document.getElementById('report-message').value = '';
        document.getElementById('report-message-count').textContent = '0';
        document.getElementById('report-reason-error').classList.add('hidden');
        
        const modal = document.getElementById('report-modal');
        const modalBox = document.getElementById('report-modal-box');
        modal.classList.remove('hidden');
        
        // Trigger animation
        setTimeout(() => {
            modalBox.classList.remove('scale-95', 'opacity-0');
            modalBox.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    /**
     * Close report modal
     */
    function closeReportModal() {
        const modal = document.getElementById('report-modal');
        const modalBox = document.getElementById('report-modal-box');
        
        modalBox.classList.add('scale-95', 'opacity-0');
        modalBox.classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            currentReportAspirationId = null;
        }, 300);
    }

    /**
     * Character counter for message textarea
     */
    document.getElementById('report-message').addEventListener('input', function() {
        document.getElementById('report-message-count').textContent = this.value.length;
    });

    /**
     * Submit report
     */
    async function submitReport() {
        const reason = document.getElementById('report-reason').value;
        const message = document.getElementById('report-message').value;
        const reasonError = document.getElementById('report-reason-error');
        const submitBtn = document.getElementById('report-submit-btn');
        const loading = document.getElementById('report-loading');

        // Validate
        if (!reason) {
            reasonError.classList.remove('hidden');
            reasonError.textContent = 'Pilih alasan laporan';
            return;
        }
        reasonError.classList.add('hidden');

        if (!currentReportAspirationId) {
            alert('Error: Aspiration ID not found');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        loading.classList.remove('hidden');

        try {
            const response = await fetch('./api/board/report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_aspirasi: currentReportAspirationId,
                    reason: reason,
                    message: message || null
                })
            });

            const result = await response.json();

            if (result.success) {
                // Show success message
                alert('✅ Laporan berhasil dikirim! Terima kasih telah membantu kami.');
                closeReportModal();
            } else {
                // Show error message
                alert('❌ Error: ' + (result.message || 'Gagal mengirim laporan'));
            }
        } catch (error) {
            console.error('Report submission error:', error);
            alert('❌ Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            loading.classList.add('hidden');
        }
    }

    // Close modal when clicking outside
    document.getElementById('report-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReportModal();
        }
    });

    // Initialize lucide icons when modal opens
    const originalOpenModal = openReportModal;
    window.openReportModal = function(id, title, description) {
        originalOpenModal(id, title, description);
        lucide.createIcons();
    };
</script>