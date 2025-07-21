<?php
// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    // Set session cookie parameters
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => 86400, // 24 hours
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    
    // Start the session
    session_start();
    
    // Regenerate session ID to prevent session fixation
    if (empty($_SESSION['last_activity'])) {
        session_regenerate_id(true);
        $_SESSION['last_activity'] = time();
    }
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Redirect if not logged in
function require_login() {
    if (!is_logged_in()) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: /login.php');
        exit();
    }
}

// Set a flash message
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

// Get and clear flash message
function get_flash_message() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
?>
