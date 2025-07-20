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
                <span class="logo-text">ZedMemes</span>
            </div>
        </div>

        <!-- Menu Items -->
        <ul class="menu-items">
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Only visible to logged-in users -->
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Create Meme</button>
                </li>
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Remove Meme</button>
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
                    <a href="pages/login.php" class="menu-button login-btn">Login</a>
                </li>
                <li>
                    <a href="pages/signup.php" class="menu-button signup-btn">Sign Up</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

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
            window.location.href = '/';
        } else {
            alert('Logout failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Logout error:', error);
        // Fallback redirect in case of error
        window.location.href = '/';
    }
});
</script>