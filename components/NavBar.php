<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="logo-container">
            <div class="logo">
                <a href="/zedmemes-new/" class="logo-text">ZedMemes</a>
            </div>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" aria-label="Toggle menu">
            <span class="menu-icon">☰</span>
            <span class="close-icon" style="display: none;">✕</span>
        </button>

        <!-- Menu Items -->
        <ul class="menu-items">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Only visible to logged-in users -->
                <li>
                    <a href="/zedmemes-new/" class="menu-button">Home</a>
                </li>
                <li>
                    <a href="/zedmemes-new/create_meme" class="menu-button">Create Meme</a>
                </li>
                <li>
                    <a href="/zedmemes-new/my_memes" class="menu-button">My Memes</a>
                </li>
                <li>
                    <a href="#" id="logout-btn" class="menu-button">Logout</a>
                </li>
            <?php else: ?>
                <!-- Only visible to guests -->
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Filter</button>
                </li>
                <li>
                    <a href="/zedmemes-new/login" class="menu-button login-btn">Login</a>
                </li>
                <li>
                    <a href="/zedmemes-new/signup" class="menu-button signup-btn">Sign Up</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Include Navigation Script -->
<script src="/js/navbar.js"></script>

<script>
// Handle logout button click
document.getElementById('logout-btn')?.addEventListener('click', async function(e) {
    e.preventDefault();
    
    if (!confirm('Are you sure you want to log out?')) {
        return;
    }
    
    try {
        const response = await fetch('../handler/logout.php', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'  // Important for sending cookies/session
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Redirect to login page after successful logout
            window.location.href = '/zedmemes-new/login';
        } else {
            alert('Logout failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Logout error:', error);
        // Fallback redirect in case of error
        window.location.href = '/zedmemes-new/login';
    }
});
</script>