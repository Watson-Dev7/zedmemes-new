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
            // Check if the test user exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // For testing, verify password for the test user
            if ($user && ($username === 'testuser' && $password === 'test123')) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /pages/create_meme.php');
                exit();
            } else {
                $error = 'Invalid username or password. Try username: testuser, password: test123';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css">
    <link rel="stylesheet" href="/css/style.css">
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
    <div class="login-container" style="max-width: 500px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h1 style="text-align: center; color: #2c3e50; margin-bottom: 2rem;">Login to ZedMemes</h1>
        
        <?php if ($error): ?>
            <div class="callout alert" style="margin-bottom: 1.5rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="callout primary" style="margin-bottom: 2rem;">
            <h5>Test Credentials</h5>
            <p><strong>Username:</strong> testuser</p>
            <p><strong>Password:</strong> test123</p>
        </div>
        
        <form method="POST" action="" style="margin-bottom: 1.5rem;">
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="cell">
                        <label>Username
                            <input type="text" name="username" placeholder="Enter username" required>
                        </label>
                    </div>
                    <div class="cell">
                        <label>Password
                            <input type="password" name="password" placeholder="Enter password" required>
                        </label>
                    </div>
                    <div class="cell">
                        <button type="submit" class="button expanded" style="margin-top: 1rem;">Login</button>
                    </div>
                </div>
            </div>
        </form>
        
        <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e6e6e6;">
            <p>Don't have an account? <a href="#" onclick="alert('Use the test credentials to login'); return false;">Sign up here</a></p>
        </div>    
    </div>
</body>
</html>
