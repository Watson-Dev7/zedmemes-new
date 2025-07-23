<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    if ($username && $email && $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            $message = "Account created successfully!";
        } else {
            $message = "Error creating account.";
        }
    } else {
        $message = "All fields are required.";
    }
}
?>




<div class="login-wrapper">
    <form class="login-form" id="signup-form"  method="POST">
        <h2>Create Account</h2>

        <div id="error-message" class="error-message" style="color: red; display: none; margin-bottom: 15px;"></div>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="login-btn">Sign Up</button>

        <div class="signup-text">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</div>



<script>
    document.getElementById('signup-form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const errorElement = document.getElementById('error-message');
        errorElement.style.display = 'none';

        const username = form.username.value.trim();
        const email = form.email.value.trim();
        const password = form.password.value;

        try {
            const response = await fetch('../handler/auth-handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    action: 'signup',
                    username: username,
                    email: email,
                    password: password
                })
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = result.redirect || '/zedmemes-new';
            } else {
                throw new Error(result.message || 'Signup failed');
            }
        } catch (error) {
            errorElement.textContent = error.message || 'An error occurred. Please try again.';
            errorElement.style.display = 'block';
            console.error('Signup error:', error);
        }
    });
</script>