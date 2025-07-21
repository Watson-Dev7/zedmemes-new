<?php
require_once 'config/database.php';
require_once 'includes/session.php';

// Function to create test user if not exists
function createTestUser($pdo) {
    $username = 'testuser';
    $email = 'test@example.com';
    $password = 'test123';
    
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // Create test user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $hashedPassword]);
        $userId = $pdo->lastInsertId();
        echo "Created test user with ID: $userId<br>";
    } else {
        $userId = $user['id'];
        echo "Test user already exists with ID: $userId<br>";
    }
    
    return $userId;
}

// Create test user if needed
$testUserId = createTestUser($pdo);

// Set session
session_start();
$_SESSION['user_id'] = $testUserId;
$_SESSION['username'] = 'testuser';
$_SESSION['logged_in'] = true;

// Verify session
if (isset($_SESSION['user_id'])) {
    echo "Session created successfully!<br>";
    echo "User ID in session: " . $_SESSION['user_id'] . "<br>";
    echo "Username in session: " . $_SESSION['username'] . "<br>";
    
    // Verify user exists in database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "User verified in database!<br>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        // Provide link to create_meme.php
        echo '<p><a href="pages/create_meme.php">Proceed to Create Meme Page</a></p>';
    } else {
        echo "Error: User not found in database!<br>";
    }
} else {
    echo "Error: Session not created properly!<br>";
}

// Show current session data
echo "<h3>Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
