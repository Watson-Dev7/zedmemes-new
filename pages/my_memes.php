<?php
require_once '../config/database.php';
require_once '../includes/session.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$error = '';
$success = isset($_GET['deleted']) ? 'Meme deleted successfully!' : '';

// Get user's memes
$memes = [];
try {
    $stmt = $pdo->prepare("SELECT id, title, image_url, created_at FROM memes WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $memes = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = 'Error loading your memes: ' . $e->getMessage();
}

// Handle meme deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['meme_id'])) {
    $meme_id = $_POST['meme_id'];
    
    try {
        // Verify meme belongs to user
        $stmt = $pdo->prepare("SELECT image_url FROM memes WHERE id = ? AND user_id = ?");
        $stmt->execute([$meme_id, $_SESSION['user_id']]);
        $meme = $stmt->fetch();
        
        if ($meme) {
            // Delete the file
            $file_path = $_SERVER['DOCUMENT_ROOT'] . $meme['image_url'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            // Delete from database
            $stmt = $pdo->prepare("DELETE FROM memes WHERE id = ? AND user_id = ?");
            $stmt->execute([$meme_id, $_SESSION['user_id']]);
            
            if ($stmt->rowCount() > 0) {
                // Redirect to avoid resubmission
                header('Location: /pages/my_memes.php?deleted=1');
                exit();
            } else {
                $error = 'Failed to delete meme.';
            }
        } else {
            $error = 'Meme not found or you do not have permission to delete it.';
        }
    } catch (PDOException $e) {
        $error = 'Error deleting meme: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Memes - ZedMemes</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .my-memes-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .page-header h1 {
            margin-bottom: 0.5rem;
        }
        .meme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }
        .meme-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            background: #fff;
        }
        .meme-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .meme-image-container {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
        }
        .meme-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .meme-card:hover .meme-image {
            transform: scale(1.05);
        }
        .meme-info {
            padding: 1rem;
        }
        .meme-title {
            font-size: 1.1rem;
            margin: 0 0 0.5rem 0;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .meme-date {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 1rem;
        }
        .meme-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-view {
            flex: 1;
            background: #4a90e2;
            color: white;
        }
        .btn-view:hover {
            background: #357abd;
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
            width: 40px;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .no-memes {
            text-align: center;
            padding: 3rem 1rem;
            grid-column: 1 / -1;
            color: #777;
        }
        .no-memes p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        .btn-create {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .btn-create:hover {
            background: #357abd;
        }
        .error {
            color: #e74c3c;
            margin: 1rem 0;
            padding: 0.75rem;
            background: #fde8e8;
            border-radius: 4px;
            border-left: 4px solid #e74c3c;
        }
        .success {
            color: #27ae60;
            margin: 1rem 0;
            padding: 0.75rem;
            background: #e8f8f0;
            border-radius: 4px;
            border-left: 4px solid #27ae60;
        }
        @media (max-width: 768px) {
            .meme-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
    </style>
</head>
<body>
    <?php include '../components/Header.php'; ?>
    <?php include '../components/NavBar.php'; ?>
    
    <div class="my-memes-container">
        <div class="page-header">
            <h1>My Memes</h1>
            <p>Manage your uploaded memes</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <?php if (empty($memes)): ?>
            <div class="no-memes">
                <p>You haven't uploaded any memes yet.</p>
                <a href="/pages/create_meme.php" class="btn-create">Create Your First Meme</a>
            </div>
        <?php else: ?>
            <div class="meme-grid">
                <?php foreach ($memes as $meme): ?>
                    <div class="meme-card">
                        <div class="meme-image-container">
                            <img src="<?= htmlspecialchars($meme['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($meme['title']) ?>" 
                                 class="meme-image">
                        </div>
                        <div class="meme-info">
                            <h3 class="meme-title" title="<?= htmlspecialchars($meme['title']) ?>">
                                <?= htmlspecialchars($meme['title']) ?>
                            </h3>
                            <p class="meme-date">
                                Uploaded on <?= date('M j, Y', strtotime($meme['created_at'])) ?>
                            </p>
                            <div class="meme-actions">
                                <a href="<?= htmlspecialchars($meme['image_url']) ?>" 
                                   target="_blank" 
                                   class="btn btn-view">
                                    View
                                </a>
                                <form method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this meme? This action cannot be undone.');"
                                      style="display: inline;">
                                    <input type="hidden" name="meme_id" value="<?= $meme['id'] ?>">
                                    <button type="submit" class="btn btn-delete" title="Delete meme">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include '../components/Footer.php'; ?>
    
    <script>
    // Confirm before deleting
    document.querySelectorAll('form[onsubmit]').forEach(form => {
        form.onsubmit = function() {
            return confirm('Are you sure you want to delete this meme? This action cannot be undone.');
        };
    });
    </script>
</body>
</html>
