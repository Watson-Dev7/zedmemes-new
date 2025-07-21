<?php
require_once 'config/database.php';

try {
    // Drop tables if they exist (be careful with this in production!)
    $pdo->exec("DROP TABLE IF EXISTS memes");
    $pdo->exec("DROP TABLE IF EXISTS users");

    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Create memes table with proper foreign key
    $pdo->exec("CREATE TABLE IF NOT EXISTS memes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Create a test user
    $username = 'testuser';
    $email = 'test@example.com';
    $password = 'test123';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password_hash]);
    $userId = $pdo->lastInsertId();

    echo "<h2>Database setup complete!</h2>";
    echo "<p>Test user created:</p>";
    echo "<ul>";
    echo "<li>Username: $username</li>";
    echo "<li>Email: $email</li>";
    echo "<li>Password: $password</li>";
    echo "<li>User ID: $userId</li>";
    echo "</ul>";
    
    // Verify the user was created
    $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>User record from database:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
    
    echo "<p><a href='/test_login.php'>Proceed to login page</a></p>";

} catch (PDOException $e) {
    echo "<h2>Error setting up database:</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
?>
