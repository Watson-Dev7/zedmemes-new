<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
require_once 'includes/session.php';

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        try {
            // For testing, we'll create a test user if none exists
            $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
            $user = $stmt->fetch();
            
            if (!$user) {
                // Create test user
                $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
                $pdo->exec("INSERT INTO users (username, email, password_hash) VALUES ('admin', 'admin@example.com', '$hashedPassword')");
                $user = ['id' => $pdo->lastInsertId(), 'username' => 'admin'];
            }
            
            // For testing, accept any password for the test user
            if ($username === 'admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /pages/create_meme.php');
                exit();
            } else {
                $error = 'Invalid username or password';
            }
            
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZedMemes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .btn:hover {
            background: #357abd;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #fde8e8;
            border-radius: 4px;
            border-left: 4px solid #e74c3c;
        }
        .test-credentials {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #e8f4fd;
            border-radius: 4px;
            border-left: 4px solid #4a90e2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="test-credentials">
            <h3>Test Credentials</h3>
            <p><strong>Username:</strong> admin</p>
            <p><strong>Password:</strong> admin123</p>
        </div>
    </div>
</body>
</html>
