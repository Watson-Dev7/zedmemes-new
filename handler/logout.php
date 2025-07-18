<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Delete the session cookie (optional but recommended)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Send JSON response to confirm logout (or redirect)
$response = [
    'success' => true,
    'message' => 'Logged out successfullyy.'
];

header('Content-Type: application/json'); 
echo json_encode($response);
exit;
?>
