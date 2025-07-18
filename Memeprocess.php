<?php
// Include the database connection
require_once __DIR__ . '/handler/DatabaseConnection.php';

// Global database connection variable
$insert = null;

// Function to get database connection
function getDbConnection() {
    global $insert;
    
    if ($insert === null || !($insert instanceof mysqli) || !$insert->ping()) {
        try {
            $insert = connection();
            if (!($insert instanceof mysqli)) {
                throw new Exception('Failed to establish database connection');
            }
            // Set charset to ensure proper encoding
            if (!$insert->set_charset('utf8mb4')) {
                throw new Exception('Error setting charset: ' . $insert->error);
            }
        } catch (Exception $e) {
            error_log('Database connection error: ' . $e->getMessage());
            if (php_sapi_name() === 'cli') {
                die('Database connection failed: ' . $e->getMessage() . "\n");
            }
            if (!headers_sent()) {
                header('Content-Type: application/json');
                die(json_encode(['success' => false, 'message' => 'Database connection failed']));
            }
            exit(1);
        }
    }
    
    return $insert;
}

// Initialize the connection when this file is included
getDbConnection();
// $sql="insert into image(filename) Values('$img')";

//  insert->query($sql);
//  echo "Data inserted Succesfully";
//  insert->close();

 
// }

function uploadMeme($filename) 
{
    try {
        $db = getDbConnection();
        $stmt = $db->prepare("INSERT INTO image (filename) VALUES (?)");
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $db->error);
        }
        
        $stmt->bind_param("s", $filename);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Upload successful'];
        } else {
            throw new Exception('Execute failed: ' . $stmt->error);
        }
    } catch (Exception $e) {
        error_log('Upload error: ' . $e->getMessage());
        return ['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()];
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}


function retrieveMeme()
{
    $arrayImage = [];
    $result = null;
    
    try {
        $db = getDbConnection();
        $sql = "SELECT * FROM image ORDER BY id DESC";
        $result = $db->query($sql);
        
        if (!$result) {
            throw new Exception('Query failed: ' . $db->error);
        }
        
        while ($row = $result->fetch_assoc()) {
            $arrayImage[] = [
                "id" => $row["id"],
                "name" => $row["filename"]
            ];
        }
        
        return $arrayImage;
        
    } catch (Exception $e) {
        error_log('Retrieve meme error: ' . $e->getMessage());
        if (php_sapi_name() !== 'cli') {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to retrieve memes']);
        }
        return [];
    } finally {
        if ($result) {
            $result->close();
        }
    }
}



?>