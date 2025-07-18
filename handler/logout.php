<?php
session_start();
session_unset();
session_destroy();

// Return a JSON response (for frontend fetch)
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Session ended']);
exit();
