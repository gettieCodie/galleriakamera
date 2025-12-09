/**
 * Toast Notification System
 * Provides a flexible notification/toast system for user feedback
 */

class ToastNotification {
    constructor() {
        this.container = null;
        this.toasts = [];
        this.initializeContainer();
    }

    /**
     * Initialize the toast container if it doesn't exist
     */
    initializeContainer() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.className = 'toast-container';
            this.container.id = 'toast-container';
            document.body.appendChild(this.container);
        }
    }

    /**
     * Show a toast notification
     * @param {Object} options - Toast options
     * @param {string} options.type - Type of toast: 'success', 'error', 'warning', 'info', 'loading'
     * @param {string} options.title - Toast title
     * @param {string} options.message - Toast message (optional)
     * @param {number} options.duration - Duration in milliseconds (default: 5000, 0 for no auto-close)
     * @param {boolean} options.closable - Show close button (default: true)
     */
    show(options = {}) {
        const {
            type = 'info',
            title = '',
            message = '',
            duration = 5000,
            closable = true
        } = options;

        // Create toast element
        const toast = document.createElement('div');
        const toastId = `toast-${Date.now()}-${Math.random()}`;
        toast.id = toastId;
        toast.className = `toast toast-${type}`;

        // Create icon
        const icon = this.getIcon(type);
        const iconElement = document.createElement('div');
        iconElement.className = 'toast-icon';
        iconElement.innerHTML = icon;
        toast.appendChild(iconElement);

        // Create content
        const contentElement = document.createElement('div');
        contentElement.className = 'toast-content';
        
        if (title) {
            const titleElement = document.createElement('p');
            titleElement.className = 'toast-title';
            titleElement.textContent = title;
            contentElement.appendChild(titleElement);
        }

        if (message) {
            const messageElement = document.createElement('p');
            messageElement.className = 'toast-message';
            messageElement.textContent = message;
            contentElement.appendChild(messageElement);
        }

        toast.appendChild(contentElement);

        // Create close button
        if (closable) {
            const closeButton = document.createElement('button');
            closeButton.className = 'toast-close';
            closeButton.innerHTML = '&times;';
            closeButton.onclick = () => this.remove(toastId);
            toast.appendChild(closeButton);
        }

        // Add progress bar if duration is set
        if (duration > 0) {
            const progressBar = document.createElement('div');
            progressBar.className = 'toast-progress';
            progressBar.style.animation = `progress ${duration / 1000}s linear forwards`;
            toast.appendChild(progressBar);
        }

        // Add to container
        this.container.appendChild(toast);
        this.toasts.push(toastId);

        // Auto-remove after duration
        if (duration > 0) {
            setTimeout(() => this.remove(toastId), duration);
        }

        return toastId;
    }

    /**
     * Get icon HTML for toast type
     */
    getIcon(type) {
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-exclamation-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>',
            loading: '<i class="fas fa-spinner"></i>'
        };
        return icons[type] || icons.info;
    }

    /**
     * Remove a toast by ID
     */
    remove(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.add('removing');
            setTimeout(() => {
                toast.remove();
                this.toasts = this.toasts.filter(id => id !== toastId);
            }, 300);
        }
    }

    /**
     * Remove all toasts
     */
    removeAll() {
        this.toasts.forEach(toastId => this.remove(toastId));
    }

    /**
     * Show success notification
     */
    success(title, message = '', duration = 5000) {
        return this.show({ type: 'success', title, message, duration });
    }

    /**
     * Show error notification
     */
    error(title, message = '', duration = 5000) {
        return this.show({ type: 'error', title, message, duration });
    }

    /**
     * Show warning notification
     */
    warning(title, message = '', duration = 5000) {
        return this.show({ type: 'warning', title, message, duration });
    }

    /**
     * Show info notification
     */
    info(title, message = '', duration = 5000) {
        return this.show({ type: 'info', title, message, duration });
    }

    /**
     * Show loading notification
     */
    loading(title, message = '') {
        return this.show({ type: 'loading', title, message, duration: 0, closable: false });
    }

    /**
     * Update an existing toast
     */
    update(toastId, options = {}) {
        const toast = document.getElementById(toastId);
        if (!toast) return;

        const { type, title, message, closable } = options;

        if (type) {
            // Remove old type classes
            toast.classList.forEach(cls => {
                if (cls.startsWith('toast-')) {
                    toast.classList.remove(cls);
                }
            });
            toast.classList.add(`toast-${type}`);

            // Update icon
            const iconElement = toast.querySelector('.toast-icon');
            if (iconElement) {
                iconElement.innerHTML = this.getIcon(type);
            }
        }

        if (title !== undefined) {
            const titleElement = toast.querySelector('.toast-title');
            if (titleElement) {
                titleElement.textContent = title;
            }
        }

        if (message !== undefined) {
            const messageElement = toast.querySelector('.toast-message');
            if (messageElement) {
                messageElement.textContent = message;
            }
        }
    }
}

// Create global toast instance
const Toast = new ToastNotification();

// Add CSS animation for progress bar dynamically if not already added
if (!document.querySelector('style[data-toast-progress]')) {
    const style = document.createElement('style');
    style.setAttribute('data-toast-progress', 'true');
    style.textContent = `
        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
        }
    `;
    document.head.appendChild(style);
}
