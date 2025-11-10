// Sistema de notificaciones mejorado
class NotificationSystem {
    constructor() {
        this.container = null;
        this.init();
    }

    init() {
        // Crear contenedor si no existe
        if (!document.getElementById('notification-container')) {
            this.container = document.createElement('div');
            this.container.id = 'notification-container';
            this.container.className = 'notification-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('notification-container');
        }
    }

    show(message, type = 'info', title = null, duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;

        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        const titles = {
            success: title || '¡Éxito!',
            error: title || 'Error',
            warning: title || 'Advertencia',
            info: title || 'Información'
        };

        notification.innerHTML = `
            <div class="notification-icon">${icons[type]}</div>
            <div class="notification-content">
                <div class="notification-title">${titles[type]}</div>
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>
        `;

        this.container.appendChild(notification);

        // Auto-cerrar después de la duración especificada
        setTimeout(() => {
            notification.classList.add('hiding');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    }

    success(message, title = null) {
        this.show(message, 'success', title);
    }

    error(message, title = null) {
        this.show(message, 'error', title);
    }

    warning(message, title = null) {
        this.show(message, 'warning', title);
    }

    info(message, title = null) {
        this.show(message, 'info', title);
    }
}

// Crear instancia global
const notify = new NotificationSystem();
