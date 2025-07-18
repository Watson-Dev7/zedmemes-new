<?php
// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die('The mysqli extension is not available. Please enable it in your PHP configuration.');
}

function connection() {
    $host = 'localhost';
    $db = 'zedmemes';
    $user = 'root';
    $pass = '';

    // First connect without database
    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!$conn->query($sql)) {
        die("Error creating database: " . $conn->error);
    }

    // Select the database
    if (!$conn->select_db($db)) {
        die("Error selecting database: " . $conn->error);
    }

    // Create tables
    createTables($conn);

    if ($conn->connect_error) {
        error_log('Database connection failed: ' . $conn->connect_error);
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }
    
    // Set charset to ensure proper encoding
    if (!$conn->set_charset('utf8mb4')) {
        error_log('Error setting charset: ' . $conn->error);
        throw new Exception('Error setting database charset');
    }
    
    return $conn;
}

function createTables($conn) {
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if (!$conn->query($sql)) {
        die("Error creating users table: " . $conn->error);
    }

    // Create image table
    $sql = "CREATE TABLE IF NOT EXISTS image (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        likes INT DEFAULT 0,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if (!$conn->query($sql)) {
        die("Error creating image table: " . $conn->error);
    }
}