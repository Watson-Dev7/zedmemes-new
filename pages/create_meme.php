<?php
require_once '../config/database.php';
require_once '../includes/session.php';



// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    // Basic validation
    if (empty($title)) {
        $error = 'Title is required';
    } elseif (empty($_FILES['meme_image']['tmp_name'])) {
        $error = 'Please select an image to upload';
    } else {
        // Handle file upload
        $target_dir = "../uploads/memes/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["meme_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Validate image
        $check = getimagesize($_FILES["meme_image"]["tmp_name"]);
        if ($check === false) {
            $error = 'File is not an image.';
        } elseif ($_FILES["meme_image"]["size"] > 5000000) { // 5MB
            $error = 'File is too large. Max size is 5MB.';
        } elseif (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = 'Only JPG, JPEG, PNG & GIF files are allowed.';
        } elseif (move_uploaded_file($_FILES["meme_image"]["tmp_name"], $target_file)) {
            // Save to database
            try {
                $stmt = $pdo->prepare("INSERT INTO memes (user_id, title, description, image_url) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $_SESSION['user_id'],
                    $title,
                    $description,
                    '/uploads/memes/' . $new_filename
                ]);
                
                $success = 'Meme uploaded successfully!';
                // Clear form
                $title = $description = '';
            } catch (PDOException $e) {
                $error = 'Error saving meme: ' . $e->getMessage();
                // Clean up the uploaded file if database insert fails
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            }
        } else {
            $error = 'Sorry, there was an error uploading your file.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Meme - ZedMemes</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .create-meme-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #357abd;
        }
        .preview-image {
            max-width: 100%;
            max-height: 300px;
            margin-top: 1rem;
            display: none;
            border-radius: 4px;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #fde8e8;
            border-radius: 4px;
            border-left: 4px solid #e74c3c;
        }
        .success {
            color: #27ae60;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #e8f8f0;
            border-radius: 4px;
            border-left: 4px solid #27ae60;
        }
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .file-upload-btn {
            width: 100%;
            padding: 1rem;
            border: 2px dashed #ddd;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .file-upload-btn:hover {
            border-color: #4a90e2;
            background: #f8f9fa;
        }
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../components/Header.php'; ?>
    
    <main class="create-meme-container">
        <h1>Create a New Meme</h1>
        <p>Share your funniest memes with the community</p>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" class="form-control" required 
                       value="<?= isset($title) ? htmlspecialchars($title) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea id="description" name="description" class="form-control" 
                          placeholder="Add a funny caption or context for your meme"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Meme Image *</label>
                <div class="file-upload">
                    <label class="file-upload-btn">
                        <span id="file-name">Click to select an image</span>
                        <input type="file" id="meme_image" name="meme_image" class="file-upload-input" 
                               accept="image/*" required>
                    </label>
                </div>
                <img id="image_preview" class="preview-image" src="#" alt="Preview">
                <p class="help-text">Max file size: 5MB. Allowed formats: JPG, JPEG, PNG, GIF</p>
            </div>
            
            <button type="submit" class="btn">Upload Meme</button>
        </form>
    </main>
    
    <?php include '../components/Footer.php'; ?>
    
    <script>
    // Update file name display
    document.getElementById('meme_image').addEventListener('change', function(e) {
        const fileName = this.files[0] ? this.files[0].name : 'Click to select an image';
        document.getElementById('file-name').textContent = fileName;
        
        // Show image preview
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('image_preview');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image_preview').style.display = 'none';
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('meme_image');
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (fileInput.files.length > 0 && fileInput.files[0].size > maxSize) {
            e.preventDefault();
            alert('File is too large. Maximum size is 5MB.');
        }
    });
    </script>
</body>
</html>