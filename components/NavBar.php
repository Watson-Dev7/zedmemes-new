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
            <?php else: ?>
                <!-- Only visible to guests -->
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Filter</button>
                </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Profile dropdown only for logged-in users -->
                <li class="profile-dropdown">
                    <button id="profile-btn" class="icon-button" onclick="toggleProfile()">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 
                     0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 
                     29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                        </svg>
                    </button>

                    <div id="profile-overlay" class="profile-overlay hidden">
                        <div class="">
                            <img src="zedmems.jpg" alt="Profile Picture" class="profile-pic">
                            <h3><?= htmlspecialchars($_SESSION['username'] ?? 'user') ?></h3>
                            <div class="popup-actions">
                                <button type="button" class="cta-button" id="logout-btn" data-href="logout.php">Log
                                    Out</button>
                                <button onclick="closeProfile()">Close</button>
                            </div>
                        </div>
                    </div>
                </li>
            <?php else: ?>
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
    document.getElementById('logout-btn')?.addEventListener('click', async function () {
        if (!confirm("Are you sure you want to logout?")) return;

        try {
            const response = await fetch('../handler/logout.php', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // Optionally handle response:
            // const result = await response.json();
            // if (result.success) window.location.href = '../pages/login.php';

            // Simple fallback redirect:
            // window.location.href = '../pages/login.php';

        } catch (error) {
            alert('Logout failed. Please try again.');
            console.error('Logout error:', error);
        }
    });

    function toggleProfile() {
        document.getElementById("profile-overlay").classList.toggle("hidden");
    }

    function closeProfile() {
        document.getElementById("profile-overlay").classList.add("hidden");
    }
</script>