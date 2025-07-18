<?php

header('Content-Type: application/json'); // Ensure JSON response

include __DIR__ . '/Memeprocess.php';

if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../img/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['image']['name']);
    $filePath = $uploadDir . uniqid() . '_' . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        // Return the correct web-accessible path
        $webPath = '/' . ltrim($filePath, '/'); // Ensure leading slash
        echo json_encode([
            'success' => true,
            'filePath' => $webPath,
            'debug' => [
                'full_server_path' => realpath($filePath),
            ]
        ]);
        // uploading the meme and processing it to database 'uploadMeme' is the function from Memeprocess.php 
       try{
              
              $cleanPath = ltrim($filePath, '.'); // Removes leading dots and slashes
// Result: "img/68783ddc3c1f8_IMG-20240318-WA0019(1).jpg"
          
            //    $name="/img/$fileName";
               $name="$webPath";
              uploadMeme($cleanPath);

        
          }
              catch(Exception $e)
          {
                echo " An error Happened :". $e->getMessage();
         }
       
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to move file']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Upload error: ' . $_FILES['image']['error']]);
}
?>