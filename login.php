<?php
header('Content-Type: application/json');
session_start();

// Include database connection
require_once 'DatabaseConnection.php';

// Initialize response array
$response = ['success' => false, 'message' => ''];

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get and sanitize inputs
    $action = $_POST['action'] ?? '';
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = $_POST['password'] ?? '';
    
    // Basic validation
    if (empty($username)) {
        throw new Exception('Username is required');
    }
    
    if (empty($password)) {
        throw new Exception('Password is required');
    }

    // Get database connection
    $conn = connection();
    
    if ($action === 'signup') {
        // Handle signup
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
        
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            throw new Exception('Username already exists');
        }
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            throw new Exception('Email already registered');
        }
        
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password_hash);
        
        if ($stmt->execute()) {
            // Set session variables
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            
            $response = [
                'success' => true,
                'message' => 'Registration successful',
                'redirect' => 'index.php'
            ];
        } else {
            throw new Exception('Registration failed. Please try again.');
        }
    } else {
        // Handle login
        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            $response = [
                'success' => true,
                'message' => 'Login successful',
                'redirect' => 'index.php'
            ];
        } else {
            throw new Exception('Invalid username or password');
        }
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
exit();