<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers for Server-Sent Events
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Important for Nginx servers

// Set time limit and disable time limit
set_time_limit(0);
ignore_user_abort(true);

// Function to send SSE message
function sendSseMessage($data, $event = null) {
    if ($event !== null) {
        echo "event: $event\n";
    }
    echo 'data: ' . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

try {
    // Include the Memeprocess file
    require_once __DIR__ . '/Memeprocess.php';
    
    // Set end time (5 minutes from now)
    $endTime = time() + 300; // 5 minutes
    $lastUpdate = 0;
    
    // Main SSE loop
    while (time() < $endTime && connection_status() == CONNECTION_NORMAL) {
        // Send heartbeat every 15 seconds to keep connection alive
        if ((time() - $lastUpdate) >= 15) {
            sendSseMessage(['type' => 'heartbeat', 'time' => date('Y-m-d H:i:s')]);
            $lastUpdate = time();
        }
        
        try {
            // Get meme data
            $memeData = retrieveMeme();
            
            // Send data to client
            sendSseMessage([
                'success' => true,
                'data' => $memeData,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            // Small delay to prevent high CPU usage
            usleep(2000000); // 2 seconds
            
        } catch (Exception $e) {
            error_log('Error retrieving memes: ' . $e->getMessage());
            sendSseMessage([
                'success' => false,
                'error' => 'Failed to retrieve memes',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            // Wait a bit before retrying
            sleep(5);
        }
    }
    
    // Send close event
    sendSseMessage(['type' => 'close', 'message' => 'Connection closed'], 'close');
    
} catch (Exception $e) {
    // Log the error
    error_log('SSE Error: ' . $e->getMessage());
    
    // Try to send an error message to the client
    if (!headers_sent()) {
        sendSseMessage([
            'success' => false,
            'error' => 'Server error occurred',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}

// Ensure no further output
if (ob_get_level() > 0) {
    ob_end_flush();
}
?>