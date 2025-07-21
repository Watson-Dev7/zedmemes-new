<?php
require_once 'config/database.php';
session_start();

// Get current session info
echo "<h1>Fixing Session</h1>";
echo "<pre>Current session user_id: " . ($_SESSION['user_id'] ?? 'not set') . "</pre>";

// Check if user exists in database
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "<p>User found in database:</p>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    } else {
        echo "<p>User with ID {$_SESSION['user_id']} not found in database. Fixing session...</p>";
        
        // Find the test user
        $stmt = $pdo->query("SELECT id, username FROM users WHERE username = 'testuser' LIMIT 1");
        $testUser = $stmt->fetch();
        
        if ($testUser) {
            // Update session with correct user ID
            $_SESSION['user_id'] = $testUser['id'];
            $_SESSION['username'] = $testUser['username'];
            echo "<p>Session updated! New user_id: {$_SESSION['user_id']}</p>";
            echo "<p><a href='/pages/create_meme.php'>Try uploading a meme now</a></p>";
        } else {
            echo "<p>Test user not found. Creating test user...</p>";
            
            // Create test user if doesn't exist
            $hashedPassword = password_hash('test123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute(['testuser', 'test@example.com', $hashedPassword]);
            $userId = $pdo->lastInsertId();
            
            // Update session
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = 'testuser';
            
            echo "<p>Created test user with ID: $userId</p>";
            echo "<p><a href='/pages/create_meme.php'>Try uploading a meme now</a></p>";
        }
    }
} else {
    echo "<p>No user_id in session. Please log in first.</p>";
    echo "<p><a href='/test_login_script.php'>Log in as test user</a></p>";
}

// Show current session data
echo "<h3>Current Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<p><a href="/pages/create_meme.php">Go to Create Meme Page</a></p>
