<?php
// Include the database connection
require_once __DIR__ . '/handler/DatabaseConnection.php';

header('Content-Type: application/json');

try {
    // Test database connection
    $conn = connection();
    
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    
    // Test query
    $result = $conn->query('SELECT 1 as test');
    if (!$result) {
        throw new Exception('Query failed: ' . $conn->error);
    }
    
    $row = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'message' => 'Database connection successful!',
        'test_value' => $row['test']
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database test failed: ' . $e->getMessage(),
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

// Close connection if it exists
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
