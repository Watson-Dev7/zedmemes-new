<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

// Test database connection
try {
    // Database configuration
    $db_host = 'localhost';
    $db_name = 'zedmeme';
    $db_user = 'root';
    $db_pass = '';  // Default XAMPP password is empty

    // Create PDO instance
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Successfully connected to database: $db_name</p>";
    
    // Test if tables exist
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h2>Tables in database:</h2>";
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tables found in the database.</p>";
    }
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Database Connection Error</h2>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    
    echo "<h3>Debug Info:</h3>";
    echo "<pre>" . print_r([
        'db_host' => $db_host ?? 'Not set',
        'db_name' => $db_name ?? 'Not set',
        'db_user' => $db_user ?? 'Not set',
        'error' => $e->getMessage()
    ], true) . "</pre>";
}

// Test file permissions
echo "<h2>File Permissions:</h2>";
$dirs = [
    '/home/chief/Desktop/prototype/Zedmeme.com/uploads' => 'uploads',
    '/home/chief/Desktop/prototype/Zedmeme.com/config' => 'config',
    '/home/chief/Desktop/prototype/Zedmeme.com/includes' => 'includes'
];

echo "<ul>";
foreach ($dirs as $path => $name) {
    $writable = is_writable($path) ? '✅ writable' : '❌ not writable';
    $exists = file_exists($path) ? '✅ exists' : '❌ does not exist';
    echo "<li><strong>$name</strong>: $exists, $writable</li>";
}
echo "</ul>";

// PHP info
echo "<h2>PHP Info</h2>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✅ Enabled' : '❌ Not enabled') . "</li>";
echo "<li>File Uploads: " . (ini_get('file_uploads') ? '✅ Enabled' : '❌ Disabled') . "</li>";
echo "<li>Upload Max Filesize: " . ini_get('upload_max_filesize') . "</li>";
echo "<li>Post Max Size: " . ini_get('post_max_size') . "</li>";
echo "<li>Memory Limit: " . ini_get('memory_limit') . "</li>";
echo "</ul>";

// Test session
echo "<h2>Session Test</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['test_count'])) {
    $_SESSION['test_count'] = 1;
    echo "<p>Session started. Refresh to increment counter.</p>";
} else {
    $_SESSION['test_count']++;
    echo "<p>Session counter: " . $_SESSION['test_count'] . "</p>";
}
?>

<h2>Next Steps:</h2>
<ol>
    <li>Check database connection status above</li>
    <li>Verify required tables exist (users, memes)</li>
    <li>Check file permissions for uploads directory</li>
    <li>Verify PHP extensions (pdo_mysql, etc.)</li>
</ol>
