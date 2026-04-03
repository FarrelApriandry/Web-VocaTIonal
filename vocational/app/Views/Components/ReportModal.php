<?php

// vocational/app/Views/Components/ReportModal.php
// Reusable report modal component

?>

<div id="report-modal" class="hidden fixed inset-0 z-[200] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
    <div id="report-modal-box" class="bg-white rounded-2xl p-8 w-[90%] max-w-md shadow-2xl scale-95 opacity-0 transition-all duration-300">
        
        <!-- Close button -->
        <button id="report-modal-close" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Laporkan Aspirasi</h2>
        <p class="text-sm text-gray-600 mb-6">Membantu kami menjaga kelayakan konten di papan buletin</p>

        <!-- Report form -->
        <form id="report-form">
            
            <!-- Reason select -->
            <div class="mb-6">
                <label for="report-reason" class="block text-sm font-semibold text-gray-900 mb-2">
                    Alasan Pelaporan *
                </label>
                <select id="report-reason" name="reason" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">Pilih alasan...</option>
                    <option value="inappropriate">Konten tidak pantas</option>
                    <option value="spam">Spam atau duplikat</option>
                    <option value="offensive">Konten menyinggung/menghina</option>
                </select>
            </div>

            <!-- Message textarea -->
            <div class="mb-6">
                <label for="report-message" class="block text-sm font-semibold text-gray-900 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea id="report-message" name="message" rows="4"
                          placeholder="Jelaskan mengapa Anda melaporkan aspirasi ini..."
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-none"></textarea>
                <span class="text-xs text-gray-500 mt-1 block">Max 500 karakter</span>
            </div>

            <!-- Error message -->
            <div id="report-error" class="hidden mb-4 p-3 bg-red-100 border border-red-300 rounded-lg text-sm text-red-700"></div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="button" id="report-cancel"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </button>
                <button type="submit" id="report-submit"
                        class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors text-sm">
                    Lapor
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Report modal management
    const reportModal = document.getElementById('report-modal');
    const reportModalBox = document.getElementById('report-modal-box');
    const reportForm = document.getElementById('report-form');
    const reportError = document.getElementById('report-error');
    let currentAspirationId = null;

    // Open report modal
    function openReportModal(id_aspirasi) {
        currentAspirationId = id_aspirasi;
        reportForm.reset();
        reportError.classList.add('hidden');
        reportModal.classList.remove('hidden');
        
        setTimeout(() => {
            reportModalBox.classList.remove('scale-95', 'opacity-0');
            reportModalBox.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    // Close report modal
    function closeReportModal() {
        reportModalBox.classList.remove('scale-100', 'opacity-100');
        reportModalBox.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            reportModal.classList.add('hidden');
            currentAspirationId = null;
        }, 300);
    }

    // Close button handlers
    document.getElementById('report-modal-close').addEventListener('click', closeReportModal);
    document.getElementById('report-cancel').addEventListener('click', closeReportModal);

    // Background click to close
    reportModal.addEventListener('click', function(e) {
        if (e.target === reportModal) {
            closeReportModal();
        }
    });

    // Submit report
    reportForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!currentAspirationId) {
            reportError.textContent = 'Error: Aspiration ID not found';
            reportError.classList.remove('hidden');
            return;
        }

        const reason = document.getElementById('report-reason').value;
        const message = document.getElementById('report-message').value;

        if (!reason) {
            reportError.textContent = 'Mohon pilih alasan pelaporan';
            reportError.classList.remove('hidden');
            return;
        }

        try {
            const response = await fetch('./api/board/report.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id_aspirasi: currentAspirationId,
                    reason: reason,
                    message: message || null
                })
            });

            const result = await response.json();

            if (result.success) {
                // Show success message
                reportError.classList.add('hidden');
                reportForm.innerHTML = '<div class="text-center py-6"><i data-lucide="check-circle" class="w-12 h-12 text-green-500 mx-auto mb-4"></i><p class="text-green-700 font-semibold">Laporan berhasil dikirim!</p><p class="text-sm text-gray-600 mt-2">Terima kasih telah membantu menjaga kelayakan konten.</p></div>';
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                setTimeout(() => {
                    closeReportModal();
                    reportForm.innerHTML = reportForm.innerHTML; // Reset form
                }, 2000);
            } else {
                reportError.textContent = result.message || 'Gagal mengirim laporan';
                reportError.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Report error:', error);
            reportError.textContent = 'Terjadi kesalahan saat mengirim laporan';
            reportError.classList.remove('hidden');
        }
    });

    // Expose function globally for buttons to call
    window.openReportModal = openReportModal;
</script>