<?php
require 'config/db.php';
header('Content-Type: application/json');

try {
    $username = trim($_POST['username'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (strlen($username) < 3) throw new Exception('Username must be at least 3 characters');
    if (!$email) throw new Exception('Invalid email address');
    if (strlen($password) < 8) throw new Exception('Password must be at least 8 characters');
    if ($password !== $confirmPassword) throw new Exception('Passwords do not match');

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) throw new Exception('Email already registered');

    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $firstName = explode('@', $email)[0]; // Use part of email as first name
    $lastName = 'User'; // Default last name

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $email, $hash, $firstName, $lastName]);

    session_start();
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

    echo json_encode(['status' => 'success', 'username' => $username]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>