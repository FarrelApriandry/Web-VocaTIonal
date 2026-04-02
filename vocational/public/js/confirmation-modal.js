/**
 * Generic Reusable Confirmation Modal API
 * 
 * Usage:
 * window.confirmationModal.open({
 *     title: 'Hapus Item',
 *     message: 'Apakah Anda yakin ingin menghapus item ini?',
 *     confirmText: 'Hapus',
 *     cancelText: 'Batal',
 *     confirmBtnColor: 'red', // 'blue' (default), 'red', 'green', 'orange'
 *     onConfirm: async () => { console.log('Confirmed!'); },
 *     onCancel: () => { console.log('Cancelled!'); }
 * });
 */

window.confirmationModal = (() => {
    const state = {
        isOpen: false,
        onConfirmCallback: null,
        onCancelCallback: null,
        isProcessing: false
    };

    const DOM = {
        modal: document.getElementById('confirmation-modal'),
        modalBox: document.getElementById('confirmation-modal-box'),
        title: document.getElementById('confirmation-title'),
        message: document.getElementById('confirmation-message'),
        confirmBtn: document.getElementById('confirmation-confirm-btn'),
        cancelBtn: document.getElementById('confirmation-cancel-btn')
    };

    /**
     * Color variants for confirm button
     */
    const buttonColorClasses = {
        blue: 'bg-blue-900 hover:bg-blue-800',
        red: 'bg-red-600 hover:bg-red-700',
        green: 'bg-green-600 hover:bg-green-700',
        orange: 'bg-orange-600 hover:bg-orange-700',
        gray: 'bg-gray-600 hover:bg-gray-700'
    };

    /**
     * Open confirmation modal with custom options
     * @param {Object} options
     * @param {string} options.title - Modal title
     * @param {string} options.message - Modal message
     * @param {string} [options.confirmText='Konfirmasi'] - Confirm button text
     * @param {string} [options.cancelText='Batal'] - Cancel button text
     * @param {string} [options.confirmBtnColor='blue'] - Button color variant
     * @param {Function} [options.onConfirm] - Callback when confirmed
     * @param {Function} [options.onCancel] - Callback when cancelled
     */
    const open = (options = {}) => {
        const {
            title = 'Konfirmasi Aksi',
            message = 'Apakah Anda yakin ingin melakukan aksi ini?',
            confirmText = 'Konfirmasi',
            cancelText = 'Batal',
            confirmBtnColor = 'blue',
            onConfirm = null,
            onCancel = null
        } = options;

        // Set content
        DOM.title.textContent = title;
        DOM.message.textContent = message;
        DOM.confirmBtn.textContent = confirmText.toUpperCase();
        DOM.cancelBtn.textContent = cancelText.toUpperCase();

        // Set button color
        const colorClass = buttonColorClasses[confirmBtnColor] || buttonColorClasses.blue;
        DOM.confirmBtn.className = `flex-1 py-3 md:py-4 rounded-xl font-bold text-white transition-all uppercase tracking-widest text-xs shadow-lg ${colorClass}`;

        // Set callbacks
        state.onConfirmCallback = onConfirm;
        state.onCancelCallback = onCancel;
        state.isProcessing = false;

        // Show modal with animation
        DOM.modal.classList.remove('hidden');
        state.isOpen = true;

        // Trigger animation
        setTimeout(() => {
            DOM.modalBox.classList.remove('scale-95', 'opacity-0');
            DOM.modalBox.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Update Lucide icons if available
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    };

    /**
     * Close modal
     */
    const close = () => {
        // Animation
        DOM.modalBox.classList.remove('scale-100', 'opacity-100');
        DOM.modalBox.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            DOM.modal.classList.add('hidden');
            state.isOpen = false;
            state.onConfirmCallback = null;
            state.onCancelCallback = null;

            // Restore body scroll
            document.body.style.overflow = '';
        }, 300);

        // Call cancel callback
        if (state.onCancelCallback && typeof state.onCancelCallback === 'function') {
            state.onCancelCallback();
        }
    };

    /**
     * Confirm action
     */
    const confirm = async () => {
        if (state.isProcessing) return;

        state.isProcessing = true;
        DOM.confirmBtn.disabled = true;
        DOM.cancelBtn.disabled = true;

        const originalText = DOM.confirmBtn.textContent;
        DOM.confirmBtn.textContent = 'MEMPROSES...';

        try {
            if (state.onConfirmCallback && typeof state.onConfirmCallback === 'function') {
                await state.onConfirmCallback();
            }

            // Close modal after success
            setTimeout(() => {
                close();
            }, 500);
        } catch (error) {
            console.error('Confirmation error:', error);
            alert('Terjadi kesalahan: ' + (error.message || 'Silakan coba lagi.'));
        } finally {
            state.isProcessing = false;
            DOM.confirmBtn.textContent = originalText;
            DOM.confirmBtn.disabled = false;
            DOM.cancelBtn.disabled = false;
        }
    };

    /**
     * Check if modal is open
     */
    const isOpen = () => state.isOpen;

    // Expose public API
    return {
        open,
        close,
        confirm,
        isOpen
    };
})();

/**
 * Keyboard shortcuts
 */
document.addEventListener('keydown', (e) => {
    if (window.confirmationModal.isOpen()) {
        if (e.key === 'Escape') {
            window.confirmationModal.close();
        }
        if (e.key === 'Enter') {
            window.confirmationModal.confirm();
        }
    }
});