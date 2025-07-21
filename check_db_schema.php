<?php
// Start session for user data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set content type to HTML
header('Content-Type: text/html; charset=utf-8');

echo "<h1>Database Schema Check</h1>";

// Function to display a table
function displayTable($title, $data) {
    if (empty($data)) {
        echo "<p>No data found for $title</p>";
        return;
    }
    
    echo "<h3>$title</h3>";
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; margin-bottom: 20px;'>";
    
    // Table header
    echo "<tr>";
    foreach (array_keys($data[0]) as $column) {
        echo "<th>" . htmlspecialchars($column) . "</th>";
    }
    echo "</tr>";
    
    // Table rows
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    
    echo "</table>";
}

try {
    // Try to include database configuration
    require_once 'config/database.php';
    
    // Verify database connection
    if (!isset($pdo)) {
        throw new Exception('Database connection failed: $pdo not initialized');
    }
    
    // Get database name from connection if not defined
    if (!defined('DB_NAME')) {
        $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();
        define('DB_NAME', $dbName ?: 'unknown_database');
    }

// Function to display a table
function displayTable($title, $data) {
    if (empty($data)) {
        echo "<p>No data found for $title</p>";
        return;
    }
    
    echo "<h2>$title</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; margin-bottom: 20px;'>";
    
    // Table header
    echo "<tr>";
    foreach (array_keys($data[0]) as $column) {
        echo "<th>" . htmlspecialchars($column) . "</th>";
    }
    echo "</tr>";
    
    // Table rows
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    
    echo "</table>";
}

try {
    // Get list of all tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h2>Database: " . DB_NAME . "</h2>";
    
    // Display each table's structure
    foreach ($tables as $table) {
        // Get table structure
        $stmt = $pdo->query("DESCRIBE `$table`");
        $structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get foreign key constraints
        $stmt = $pdo->prepare("
            SELECT 
                COLUMN_NAME, 
                CONSTRAINT_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME
            FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE 
                TABLE_SCHEMA = ? 
                AND TABLE_NAME = ?
                AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        $stmt->execute([DB_NAME, $table]);
        $foreignKeys = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Display table info
        echo "<h3>Table: $table</h3>";
        
        // Display table structure
        displayTable("Structure", $structure);
        
        // Display foreign keys
        if (!empty($foreignKeys)) {
            displayTable("Foreign Keys", $foreignKeys);
        } else {
            echo "<p>No foreign key constraints found for this table.</p>";
        }
        
        // Display sample data (first 3 rows)
        $sampleData = $pdo->query("SELECT * FROM `$table` LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($sampleData)) {
            displayTable("Sample Data (first 3 rows)", $sampleData);
        }
        
        echo "<hr>";
    }
    
    // Check if test user exists
    $testUser = $pdo->query("SELECT * FROM users WHERE username = 'testuser'")->fetch(PDO::FETCH_ASSOC);
    if ($testUser) {
        echo "<h3>Test User Exists</h3>";
        echo "<pre>";
        print_r($testUser);
        echo "</pre>";
    } else {
        echo "<h3>Test User Does Not Exist</h3>";
    }
    
} catch (PDOException $e) {
    echo "<h2>Database Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    
    // Display connection details for debugging
    echo "<h3>Connection Details:</h3>";
    echo "<pre>";
    echo "DB_HOST: " . DB_HOST . "\n";
    echo "DB_NAME: " . DB_NAME . "\n";
    echo "DB_USER: " . DB_USER . "\n";
    echo "DB_PASS: [hidden]\n";
    echo "</pre>";
}

// Display current session data
echo "<h2>Session Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Add link to test login script
echo '<p><a href="test_login_script.php">Run Test Login Script</a></p>';

// Add link to create_meme page
echo '<p><a href="pages/create_meme.php">Go to Create Meme Page</a></p>';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    pre {
        background: #f5f5f5;
        padding: 10px;
        border-radius: 4px;
        overflow-x: auto;
    }
</style>php
require_once 'config/database.php';

try {
    // Check if users table exists and show its structure
    echo "<h2>Users Table Structure</h2>";
    $stmt = $pdo->query("SHOW CREATE TABLE users");
    $table = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<pre>" . htmlspecialchars($table['Create Table'] ?? 'Table not found') . "</pre>";
    
    // Show users in the database
    echo "<h2>Current Users</h2>";
    $stmt = $pdo->query("SELECT * FROM users");
    echo "<pre>";
    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
    } else {
        echo "No users table or error querying users";
    }
    echo "</pre>";
    
    // Check memes table structure
    echo "<h2>Memes Table Structure</h2>";
    $stmt = $pdo->query("SHOW CREATE TABLE memes");
    $table = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<pre>" . htmlspecialchars($table['Create Table'] ?? 'Table not found') . "</pre>";
    
    // Show current session data
    echo "<h2>Session Data</h2>";
    echo "<pre>";
    session_start();
    print_r($_SESSION);
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "<h2>Database Error</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
?>
