<?php
header('Content-Type: application/json');
session_start();

$response = ['authenticated' => false];

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $response['authenticated'] = true;
    $response['username'] = $_SESSION['username'] ?? null;
} else {
    http_response_code(401);  // Unauthorized
    $response['message'] = 'User not authenticated';
}

echo json_encode($response);
exit();