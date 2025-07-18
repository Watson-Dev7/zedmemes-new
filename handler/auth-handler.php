<?php
header('Content-Type: application/json');
session_start();

require_once 'DatabaseConnection.php';

$response = ['success' => false, 'message' => ''];

try {
    // Validate HTTP method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method. POST required.');
    }

    // Get and sanitize POST inputs
    $action = $_POST['action'] ?? '';
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username)) {
        throw new Exception('Username is required.');
    }
    if (empty($password)) {
        throw new Exception('Password is required.');
    }

    $conn = connection(); // Get DB connection

    if ($action === 'signup') {
        handleSignup($conn, $username, $password);
    } else if ($action === 'login') {
        handleLogin($conn, $username, $password);
    } else {
        throw new Exception('Invalid action.');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    echo json_encode($response);
    exit;
}

$conn->close();

// === Functions ===
function handleSignup($conn, $username, $password) {
    global $response;

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate email
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Valid email is required.');
    }

    // Password confirmation check
    if ($password !== $confirm_password) {
        throw new Exception('Passwords do not match.');
    }

    // Check if username exists
    if (userExists($conn, 'username', $username)) {
        throw new Exception('Username already exists.');
    }

    // Check if email exists
    if (userExists($conn, 'email', $email)) {
        throw new Exception('Email already registered.');
    }

    // Hash password securely
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;

        $response = [
            'success' => true,
            'message' => 'Registration successful.',
            'redirect' => 'index.php'
        ];
    } else {
        throw new Exception('Registration failed. Please try again.');
    }

    $stmt->close();
    echo json_encode($response);
    exit;
}

function handleLogin($conn, $username, $password) {
    global $response;

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        $response = [
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => 'index.php'
        ];
    } else {
        throw new Exception('Invalid username or password.');
    }

    $stmt->close();
    echo json_encode($response);
    exit;
}

function userExists($conn, $field, $value) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE $field = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();

    $exists = $stmt->num_rows > 0;
    $stmt->close();

    return $exists;
}