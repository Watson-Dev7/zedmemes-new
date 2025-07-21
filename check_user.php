<?php
require_once 'config/database.php';

// Check if test user exists
$stmt = $pdo->query("SELECT * FROM users WHERE username = 'testuser'");
$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>User Check</h2>";
if ($user) {
    echo "<p>Test user found! ID: " . htmlspecialchars($user['id']) . "</p>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
} else {
    echo "<p>Test user not found. Creating test user...</p>";
    
    try {
        $hashed_password = password_hash('test123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute(['testuser', 'test@example.com', $hashed_password]);
        
        $userId = $pdo->lastInsertId();
        echo "<p>Test user created successfully with ID: $userId</p>";
    } catch (PDOException $e) {
        echo "<p>Error creating test user: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Show current session user
session_start();
echo "<h2>Session Info</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Show users table structure
echo "<h2>Users Table Structure</h2>";
$stmt = $pdo->query("DESCRIBE users");
$structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($structure);
echo "</pre>";

// Show memes table structure
echo "<h2>Memes Table Structure</h2>";
$stmt = $pdo->query("DESCRIBE memes");
$structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($structure);
echo "</pre>";

// Show foreign key constraints
echo "<h2>Foreign Key Constraints</h2>";
$stmt = $pdo->query("
    SELECT 
        TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM 
        INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
    WHERE 
        REFERENCED_TABLE_SCHEMA = 'zedmeme' AND 
        REFERENCED_TABLE_NAME = 'users'
");
$constraints = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($constraints);
echo "</pre>";
?>

<h2>Test Login</h2>
<form action="test_login.php" method="POST">
    <input type="hidden" name="username" value="testuser">
    <input type="hidden" name="password" value="test123">
    <button type="submit">Login as Test User</button>
</form>
