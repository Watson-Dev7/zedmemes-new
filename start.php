<?php
include __DIR__ . '/Memeprocess.php';

$MemeImg = retrieveMeme();

header('Content-Type: application/json');

if (empty($MemeImg)) {
    echo json_encode([
        "success" => false,
        "message" => "No memes found!",
        "data" => []
    ]);
} else {
    echo json_encode([
        "success" => true,
        "message" => "Data fetched successfully",
        "data" => $MemeImg
    ]);
}
?>