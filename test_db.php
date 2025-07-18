<?php
require_once 'handler/DatabaseConnection.php';

try {
    // Test database connection and table creation
    $conn = connection();
    
    // If we get here, connection was successful
    echo "✅ Successfully connected to database and created tables!\n";
    
    // Test inserting a test user
    $testUsername = 'testuser_' . time();
    $testEmail = $testUsername . '@example.com';
    $testPassword = password_hash('test123', PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $testUsername, $testEmail, $testPassword);
    
    if ($stmt->execute()) {
        $userId = $conn->insert_id;
        echo "✅ Successfully inserted test user with ID: $userId\n";
        
        // Test inserting a test image
        $testFilename = 'test_image_' . time() . '.jpg';
        $sql = "INSERT INTO image (filename, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $testFilename, $userId);
        
        if ($stmt->execute()) {
            $imageId = $conn->insert_id;
            echo "✅ Successfully inserted test image with ID: $imageId\n";
            
            // Verify data was inserted
            $result = $conn->query("SELECT u.username, i.filename 
                                   FROM users u 
                                   JOIN image i ON u.id = i.user_id 
                                   WHERE u.id = $userId");
            
            if ($result && $result->num_rows > 0) {
                echo "\n📊 Test Data Verification:";
                while ($row = $result->fetch_assoc()) {
                    echo "\n- User: " . $row['username'] . " uploaded: " . $row['filename'];
                }
                echo "\n\n✅ All tests passed successfully!\n";
            }
        }
    }
    
    // Clean up test data
    $conn->query("DELETE FROM image WHERE user_id = $userId");
    $conn->query("DELETE FROM users WHERE id = $userId");
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
