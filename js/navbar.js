document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuItems = document.querySelector('.menu-items');
    const menuOverlay = document.createElement('div');
    menuOverlay.className = 'menu-overlay';
    document.body.appendChild(menuOverlay);

    // Toggle mobile menu
    function toggleMenu() {
        menuItems.classList.toggle('active');
        menuOverlay.classList.toggle('active');
        document.body.style.overflow = menuItems.classList.contains('active') ? 'hidden' : '';
    }

    // Add menu toggle button
    if (menuToggle) {
        menuToggle.innerHTML = '☰'; // Default menu icon
        menuToggle.addEventListener('click', toggleMenu);
    }

    // Close menu when clicking on overlay
    menuOverlay.addEventListener('click', toggleMenu);

    // Close menu when clicking on a menu item (for single page applications)
    document.querySelectorAll('.menu-items a').forEach(item => {
        item.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                toggleMenu();
            }
        });
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 768) {
                menuItems.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }, 250);
    });
});
