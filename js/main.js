/**
 * Main JavaScript for ZedMemes
 * Handles common UI interactions and initializations
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize any tooltips or popups
    initializeTooltips();
    
    // Handle profile button and overlay
    setupProfileOverlay();
    
    // Handle any delete confirmations
    setupDeleteConfirmations();
    
    // Handle any button animations
    setupButtonAnimations();
});

/**
 * Initialize tooltips using Foundation
 */
function initializeTooltips() {
    // This will initialize any Foundation tooltips in the page
    if (typeof Foundation !== 'undefined') {
        new Foundation.Tooltip($('.has-tip'));
    }
}

/**
 * Setup profile overlay functionality
 */
function setupProfileOverlay() {
    const profileBtn = document.getElementById('profile-btn');
    const profileOverlay = document.getElementById('profile-overlay');
    
    if (profileBtn && profileOverlay) {
        profileBtn.addEventListener('click', () => {
            profileOverlay.classList.remove('hidden');
        });
        
        const closeBtn = profileOverlay.querySelector('.close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                profileOverlay.classList.add('hidden');
            });
        }
    }
}

/**
 * Setup delete confirmation dialogs
 */
function setupDeleteConfirmations() {
    document.querySelectorAll('.delete-btn, [data-confirm]').forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 'Are you sure you want to delete this item?';
            if (!confirm(message)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
    });
}

/**
 * Setup button animations
 */
function setupButtonAnimations() {
    document.querySelectorAll('.cta-button').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('.icons');
            if (icon) {
                // Trigger pop animation
                icon.classList.add('animate');
                icon.addEventListener('animationend', () => {
                    icon.classList.remove('animate');
                }, { once: true });
            }
        });
    });
}

/**
 * Show a flash message
 * @param {string} message - The message to display
 * @param {string} type - The type of message (success, error, warning, info)
 * @param {number} duration - How long to show the message in milliseconds (default: 5000)
 */
function showFlashMessage(message, type = 'info', duration = 5000) {
    const flashContainer = document.createElement('div');
    flashContainer.className = `flash-message ${type}`;
    flashContainer.textContent = message;
    
    document.body.appendChild(flashContainer);
    
    // Auto-remove after duration
    setTimeout(() => {
        flashContainer.classList.add('fade-out');
        flashContainer.addEventListener('transitionend', () => {
            flashContainer.remove();
        });
    }, duration);
}

// Make functions available globally
window.ZedMemes = {
    showFlashMessage,
    initializeTooltips,
    setupProfileOverlay,
    setupDeleteConfirmations,
    setupButtonAnimations
};