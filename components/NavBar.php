<?php
session_start();
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

            <?php if : ?>
                <!-- Only visible to logged-in users -->
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Create Meme</button>
                </li>
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Remove Meme</button>
                </li>
            <?php else: ?>
                <!-- Only visible to guests -->
                <li>
                    <button class="menu-button" onclick="triggerThrobber()">Filter</button>
                </li>
            <?php endif; ?>

            
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