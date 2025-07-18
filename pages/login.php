<?php include '../components/Header.php' ?>
<?php
session_start();
?>

<link rel="stylesheet" href="../foundatiob/css/login.css">

<div class="login-wrapper">
    <form id="login-form" class="login-form">
        <h2>ZedMemes Login</h2>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Enter your username" required />
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter your password" required />
        </div>

        <div class="options">
            <label>
                <input type="checkbox" />
                Remember me
            </label>
            <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <p class="signup-text">Don't have an account? <a href="#">Sign up</a></p>
    </form>
</div>


<script>
    document.getElementById('login-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('action', 'login');

        console.log(formData)

        const response = await fetch('../handler/auth-handler.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            window.location.href = result.redirect;
        } else {
            alert(result.message);
        }
    });
</script>


<?php include '../components/Footer.php' ?>