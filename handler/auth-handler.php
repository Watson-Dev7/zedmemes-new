<?php
header('Content-Type: application/json');
session_start();
require_once 'DatabaseConnection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$response = ['success' => false, 'message' => ''];

try {
    // Validate HTTP method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.', 405);
    }

    // Get raw POST data
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $input = $_POST; // Fallback to regular POST data
    }

    // Get and sanitize inputs
    $action = $input['action'] ?? '';
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';

    // Basic validation
    if (empty($username)) {
        throw new Exception('Username is required.');
    }
    if (empty($password)) {
        throw new Exception('Password is required.');
    }

    $conn = connection(); // Get DB connection

    if ($action === 'login') {
        handleLogin($conn, $username, $password);
    } else if ($action === 'signup') {
        handleSignup( $conn, $username,$email, $password);
    } else {
        throw new Exception('Invalid action specified.', 400);
    }

} catch (Exception $e) {
    $statusCode = $e->getCode() >= 400 ? $e->getCode() : 500;
    $response['message'] = $e->getMessage();
    sendJsonResponse($response, $statusCode);
}


// === Functions ===
function handleSignup($conn, $username,$email, $password) {
    global $response;

    // Get input data
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $confirm_password = $input['confirm_password'] ?? '';

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Valid email is required.', 400);
    }

    // Password confirmation check
    // if ($password !== $confirm_password) {
    //     throw new Exception('Passwords do not match.', 400);
    // }

    // Check if username exists
    if (userExists($conn, 'username', $username)) {
        throw new Exception('Username already exists.', 409);
    }

    // Check if email exists
    if (userExists($conn, 'email', $email)) {
        throw new Exception('Email already registered.', 409);
    }

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Database error. Please try again.', 500);
    }

    $stmt->bind_param("sss", $username, $email, $password_hash);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;

        $response = [
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => '/zedmemes-new'
        ];
        
        sendJsonResponse($response);
    } else {
        throw new Exception('Registration failed. Please try again.', 500);
    }
}
function handleLogin($conn, $username, $password) {
    global $response;

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception('Database error. Please try again.', 500);
    }

    $stmt->bind_param("s", $username);
    
    if (!$stmt->execute()) {
        throw new Exception('Login failed. Please try again.', 500);
    }
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        
        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['last_activity'] = time();

        $response = [
            'success' => true,
            'message' => 'Login successful!',
            'redirect' => '/zedmemes-new',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username']
            ]
        ];
        
        sendJsonResponse($response);
    } else {
        throw new Exception('Invalid username or password.', 401);
    }
}

function userExists($conn, $field, $value) {
    // Validate field to prevent SQL injection
    $allowedFields = ['username', 'email', 'id'];
    if (!in_array($field, $allowedFields)) {
        throw new Exception('Invalid field specified', 500);
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE `$field` = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception('Database error', 500);
    }
    
    $stmt->bind_param("s", $value);
    
    if (!$stmt->execute()) {
        $stmt->close();
        throw new Exception('Database query failed', 500);
    }
    
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();

    return $exists;
}