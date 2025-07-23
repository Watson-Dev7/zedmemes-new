<?php
include './components/Header.php';
?>

<div class="login-wrapper">
    <form id="login-form" class="login-form">
        <h2>ZedMemes Login</h2>

        <div id="error-message" class="error-message" style="color: red; display: none; margin-bottom: 15px;"></div>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required />
        </div>

        <div class="options">
            <label>
                <input type="checkbox" />
                Remember me
            </label>
            <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <p class="signup-text">Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
</div>


<script>
    document.getElementById('login-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        
        const form = e.target;
        const errorElement = document.getElementById('error-message');
        errorElement.style.display = 'none';
        
        const username = form.username.value.trim();
        const password = form.password.value;

        try {
            const response = await fetch('../handler/auth-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    action: 'login',
                    username: username,
                    password: password
                })
            });

            const result = await response.json();
            
            if (result.success) {
                window.location.href = result.redirect || '/zedmemes-new';
            } else {
                throw new Error(result.message || 'Login failed');
            }
        } catch (error) {
            errorElement.textContent = error.message || 'An error occurred. Please try again.';
            errorElement.style.display = 'block';
            console.error('Login error:', error);
        }
    });
</script>


<?php include './components/Footer.php' ?>