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
                    <a href="pages/logout.php" class="menu-button">Logout</a>
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