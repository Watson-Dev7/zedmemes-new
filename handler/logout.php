<?php
// Set headers first to prevent any output before headers
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize response array
$response = [
    'success' => false,
    'message' => 'Logout failed',
    'redirect' => '/'
];

try {
    // Unset all session variables
    $_SESSION = [];

    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            [
                'expires' => time() - 42000,
                'path' => $params["path"],
                'domain' => $params["domain"],
                'secure' => $params["secure"],
                'httponly' => $params["httponly"],
                'samesite' => 'Strict'
            ]
        );
    }

    // Destroy the session
    if (session_destroy()) {
        $response['success'] = true;
        $response['message'] = 'Logged out successfully';
    }
    
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'An error occurred during logout';
    error_log('Logout error: ' . $e->getMessage());
}

// Clear any output buffers
while (ob_get_level()) {
    ob_end_clean();
}

echo json_encode($response);
exit();
