<?php
// Simple database connection check
header('Content-Type: text/plain');
echo "=== Simple Database Check ===\n\n";

// 1. Check if config file exists
$configFile = __DIR__ . '/config/database.php';
echo "1. Checking config file ($configFile)... ";
if (file_exists($configFile)) {
    echo "FOUND\n";
    // Include the config file
    require_once $configFile;
    
    // 2. Check if PDO object is created
    echo "2. Checking database connection... ";
    if (isset($pdo) && $pdo instanceof PDO) {
        echo "CONNECTED\n";
        
        // 3. Check if users table exists
        echo "3. Checking users table... ";
        try {
            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() > 0) {
                echo "EXISTS\n";
                
                // 4. Check if test user exists
                echo "4. Checking test user... \n";
                $stmt = $pdo->query("SELECT id, username, email FROM users WHERE username = 'testuser'");
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($user) {
                    echo "   FOUND test user:\n";
                    foreach ($user as $key => $value) {
                        echo "   $key: $value\n";
                    }
                    
                    // 5. Check session
                    echo "\n5. Session status: ";
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    echo "ACTIVE\n";
                    
                    // 6. Check if user is logged in
                    echo "6. Current session data:\n";
                    echo "   user_id: " . ($_SESSION['user_id'] ?? 'NOT SET') . "\n";
                    echo "   username: " . ($_SESSION['username'] ?? 'NOT SET') . "\n";
                    
                    // 7. Check if memes table exists
                    echo "\n7. Checking memes table... ";
                    $stmt = $pdo->query("SHOW CREATE TABLE memes");
                    $createTable = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($createTable) {
                        echo "EXISTS\n";
                        echo "   Table structure:\n";
                        echo $createTable['Create Table'] . "\n";
                    } else {
                        echo "DOES NOT EXIST\n";
                    }
                    
                } else {
                    echo "   TEST USER NOT FOUND\n";
                    echo "   Trying to create test user...\n";
                    try {
                        $hashedPassword = password_hash('test123', PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
                        $stmt->execute(['testuser', 'test@example.com', $hashedPassword]);
                        $userId = $pdo->lastInsertId();
                        echo "   Created test user with ID: $userId\n";
                    } catch (PDOException $e) {
                        echo "   ERROR creating test user: " . $e->getMessage() . "\n";
                    }
                }
                
            } else {
                echo "DOES NOT EXIST\n";
                echo "   Error: The 'users' table is missing. Please run your database migrations.\n";
            }
            
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "FAILED\n";
        echo "   Error: Could not establish database connection. Check your database configuration.\n";
    }
} else {
    echo "NOT FOUND\n";
    echo "   Error: Database configuration file is missing.\n";
}

echo "\n=== Check Complete ===\n";

// Add link to create test session if not logged in
if (empty($_SESSION['user_id'])) {
    echo "\nTo create a test session, visit: http://" . $_SERVER['HTTP_HOST'] . "/test_login_script.php\n";
}
?>
