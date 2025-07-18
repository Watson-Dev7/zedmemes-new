<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Important for Nginx servers

include __DIR__ . '/Memeprocess.php';

// $MemeImg=retrieveMeme();

//     echo "data: " . json_encode([
//         "success" => true,
//         "data" => $MemeImg
//     ]) . "\n\n";
$endTime = time() + 30; // Close after 30 seconds
$lastUpdate = time();

while (time() < $endTime) {
    // Send heartbeat every 3 seconds to keep connection alive
    if ((time() - $lastUpdate) >= 3) {
        echo ": heartbeat\n\n"; // Comment-only heartbeat
        flush();
        $lastUpdate = time();
    }

    // Simulate dynamic data (e.g., from DB)
    // $users = [
    //     ["id" => 1, "name" => "/img/68780acebef3c_IMG-20240318-WA0003.jpg"],
    //     ["id" => 2, "name" => "Jane"]
    // ];
    $MemeImg=retrieveMeme();

    echo "data: " . json_encode([
        "success" => true,
        "data" => $MemeImg
    ]) . "\n\n";
    
    flush();
    
    sleep(2); // Reduced from 10 to 2 seconds
}

// Explicit close message
echo "event: close\ndata: Connection closed after 30 seconds\n\n";
flush();
?>