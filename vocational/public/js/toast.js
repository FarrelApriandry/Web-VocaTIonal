/**
 * Toast Notification System
 * Reusable, decoupled, dan scaleable
 */

class Toast {
    static #toastContainer = null;
    static #toasts = new Map();

    static {
        // Initialize container
        Toast.#initContainer();
    }

    static #initContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-4 right-4 z-[9999] flex flex-col gap-2 max-w-md pointer-events-none';
        document.body.appendChild(container);
        Toast.#toastContainer = container;
    }

    static #getToastContainer() {
        if (!Toast.#toastContainer) {
            Toast.#initContainer();
        }
        return Toast.#toastContainer;
    }

    static show(message, type = 'info', duration = 3000) {
        const toastId = Date.now() + Math.random();
        const toast = Toast.#createToastElement(message, type, toastId);
        
        Toast.#getToastContainer().appendChild(toast);
        Toast.#toasts.set(toastId, { element: toast, timeout: null });

        // Trigger animation
        setTimeout(() => {
            toast.classList.add('translate-x-0', 'opacity-100');
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 10);

        // Auto remove
        if (duration > 0) {
            const timeout = setTimeout(() => {
                Toast.remove(toastId);
            }, duration);
            
            const toastData = Toast.#toasts.get(toastId);
            if (toastData) {
                toastData.timeout = timeout;
            }
        }

        return toastId;
    }

    static #createToastElement(message, type, id) {
        const toast = document.createElement('div');
        toast.id = `toast-${id}`;
        toast.className = `
            pointer-events-auto transition-all duration-300 ease-out
            translate-x-full opacity-0
            flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg
            ${Toast.#getTypeStyles(type)}
        `;

        const icon = Toast.#getTypeIcon(type);
        const closeBtn = `
            <button 
                onclick="window.Toast.remove(${id})"
                class="ml-auto flex-shrink-0 text-current opacity-70 hover:opacity-100 transition-opacity"
                title="Close"
            >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;

        toast.innerHTML = `
            <div class="flex-shrink-0">${icon}</div>
            <div class="flex-1 text-sm font-medium">${Toast.#escapeHtml(message)}</div>
            ${closeBtn}
        `;

        return toast;
    }

    static #getTypeStyles(type) {
        const styles = {
            'success': 'bg-green-500 text-white',
            'error': 'bg-red-500 text-white',
            'warning': 'bg-yellow-500 text-white',
            'info': 'bg-blue-500 text-white'
        };
        return styles[type] || styles['info'];
    }

    static #getTypeIcon(type) {
        const icons = {
            'success': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
            'error': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
            'warning': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
            'info': '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
        };
        return icons[type] || icons['info'];
    }

    static remove(toastId) {
        const toastData = Toast.#toasts.get(toastId);
        if (!toastData) return;

        const { element, timeout } = toastData;
        
        // Clear timeout if exists
        if (timeout) clearTimeout(timeout);

        // Animate out
        element.classList.add('translate-x-full', 'opacity-0');
        element.classList.remove('translate-x-0', 'opacity-100');

        // Remove from DOM
        setTimeout(() => {
            element.remove();
            Toast.#toasts.delete(toastId);
        }, 300);
    }

    static #escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Convenience methods
    static success(message, duration) {
        return Toast.show(message, 'success', duration);
    }

    static error(message, duration) {
        return Toast.show(message, 'error', duration);
    }

    static warning(message, duration) {
        return Toast.show(message, 'warning', duration);
    }

    static info(message, duration) {
        return Toast.show(message, 'info', duration);
    }
}

// Expose globally
window.Toast = Toast;