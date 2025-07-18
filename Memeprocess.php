<?php 
include __DIR__ . '/DatabaseConnection.php';

// Global function
define("insert",connection());


// $filename='img\68752a11a4464_007f454c58ba4e128ecbc0c985fad040.jpg';
// function uploadMeme($filename)
// {
//    $img=insert->real_escape_string($filename); 
// $sql="insert into image(filename) Values('$img')";

//  insert->query($sql);
//  echo "Data inserted Succesfully";
//  insert->close();

 
// }

function uploadMeme($filename) 
{
   //  global $insert;
    
    $stmt = insert->prepare("INSERT INTO image (filename) VALUES (?)");
    $stmt->bind_param("s", $filename);
   //  $stmt->execute()
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Upload successful'];
    } else {
        return ['success' => false, 'message' => 'Upload failed'];
    }
}


function retrieveMeme()
{
 

    $arrayImage = []; // Initialize empty array (no need to predefine size)
    
    $sql = "SELECT * FROM image order by id desc";
    $result = insert->query($sql); // Make sure $insert is your valid mysqli connection
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {

 

            $arrayImage[] = [ // Append new element to array
                "id" => $row["id"],
                "name" =>$row["filename"]
            ];
        }
        $result->close();
    } else {
        // Handle query error
        echo "Error: " . $insert->error;
    }
    
    return $arrayImage; // Return the populated array
}



?>