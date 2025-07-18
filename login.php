<?php
header('Content-Type: application/json'); // Must be first line

// Initialize response array
$response = ['success' => false, 'message' => ''];

try {
    // Sanitize inputs
    $action = $_POST['action'] ?? '';
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'] ?? '';
    
    if (empty($username) ){
        throw new Exception('Username is required');
    }
    
    if (empty($password)) {
        throw new Exception('Password is required');
    }

    if ($action === 'signup') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match');
        }
        
        // Your signup logic here
        // Example: $user->register($username, $email, $password);
        $response = [
            'success' => true,
            'message' => 'Registration successful',
            'redirect' => 'index.html'
        ];
    } else {
        // Your login logic here
        // Example: $user->login($username, $password);
        $response = [
            'success' => true,
            'message' => 'Login successful',
            'redirect' => 'index.html'
        ];
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Ensure only JSON is output
echo json_encode($response);
exit;