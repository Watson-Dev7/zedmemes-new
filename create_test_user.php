<?php
require_once 'config/database.php';

try {
    // Check if test user already exists
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'testuser'");
    $user = $stmt->fetch();
    
    if (!$user) {
        // Create test user
        $hashedPassword = password_hash('test123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO users (username, email, password_hash) VALUES ('testuser', 'test@example.com', '$hashedPassword')");
        $userId = $pdo->lastInsertId();
        echo "Created test user with ID: $userId\n";
    } else {
        echo "Test user already exists with ID: " . $user['id'] . "\n";
    }
    
    // Show current users
    $stmt = $pdo->query("SELECT * FROM users");
    echo "\nCurrent users in database:\n";
    while ($row = $stmt->fetch()) {
        print_r($row);
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
