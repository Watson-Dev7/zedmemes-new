<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'zedmeme';
$db_user = 'root';
$db_pass = '';  // Default XAMPP password is empty

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Default to FETCH_ASSOC mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Log error and display a user-friendly message
    error_log('Database connection failed: ' . $e->getMessage());
    die('Could not connect to the database. Please try again later.');
}
?>