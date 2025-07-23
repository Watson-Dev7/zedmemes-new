<?php
require_once 'config/database.php';
include './components/Header.php';
require './components/homePage/Card.php';

// Sample meme data
$sampleMemes = [
    [
        'image' => 'https://i.imgflip.com/7b1bn9.jpg',
        'title' => 'Distracted Boyfriend',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ],
    [
        'image' => 'https://i.imgflip.com/1h7in3.jpg',
        'title' => 'Batman Slapping Robin',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ],
    [
        'image' => 'https://i.imgflip.com/1g8my4.jpg',
        'title' => 'Drake Hotline Bling',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ],
    [
        'image' => 'https://i.imgflip.com/9vct.jpg',
        'title' => 'Roll Safe',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ],
    [
        'image' => 'https://i.imgflip.com/1ihzfe.jpg',
        'title' => 'One Does Not Simply',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ],
    [
        'image' => 'https://i.imgflip.com/1bij.jpg',
        'title' => 'Y U No',
        'likes' => rand(100, 2500),
        'is_sample' => true
    ]
];

// Fetch uploaded memes from database
$uploadedMemes = [];
try {
    // First, check if likes table exists
    $likesTableExists = $pdo->query("SHOW TABLES LIKE 'likes'")->rowCount() > 0;
    
    if ($likesTableExists) {
        $stmt = $pdo->query("SELECT m.id, m.title, m.image_url, m.created_at, 
                             COALESCE(COUNT(l.id), 0) as likes,
                             u.username
                             FROM memes m 
                             LEFT JOIN users u ON m.user_id = u.id
                             LEFT JOIN likes l ON m.id = l.meme_id
                             GROUP BY m.id
                             ORDER BY m.created_at DESC");
    } else {
        // If likes table doesn't exist, just get memes with 0 likes
        $stmt = $pdo->query("SELECT m.id, m.title, m.image_url, m.created_at, 
                             0 as likes,
                             u.username
                             FROM memes m 
                             LEFT JOIN users u ON m.user_id = u.id
                             ORDER BY m.created_at DESC");
    }
    
    $uploadedMemes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format uploaded memes to match sample memes structure
    $uploadedMemes = array_map(function($meme) {
        $imageUrl = $meme['image_url'];
        if (!empty($imageUrl)) {
            // Remove leading slash for consistency
            $imageUrl = ltrim($imageUrl, '/');
            // If it's a local path, check if file exists
            if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                // Try to find the file in the uploads directory if it doesn't exist at the specified path
                if (!file_exists($imageUrl) && file_exists('uploads/memes/' . basename($imageUrl))) {
                    $imageUrl = 'uploads/memes/' . basename($imageUrl);
                }
            }
            // Ensure the path is web-accessible
            if (!filter_var($imageUrl, FILTER_VALIDATE_URL) && !file_exists($imageUrl)) {
                error_log("Image not found: " . $imageUrl);
            }
        }
        return [
            'id' => $meme['id'],
            'image' => $imageUrl,
            'title' => $meme['title'],
            'likes' => (int)$meme['likes'],
            'username' => $meme['username'],
            'created_at' => $meme['created_at'],
            'is_sample' => false
        ];
    }, $uploadedMemes);
    
} catch (PDOException $e) {
    error_log("Error fetching memes: " . $e->getMessage());
}

// Combine sample and uploaded memes
$allMemes = array_merge($sampleMemes, $uploadedMemes);

// Randomize the order while preserving keys
$keys = array_keys($allMemes);
shuffle($keys);
$shuffledMemes = [];
foreach ($keys as $key) {
    $shuffledMemes[$key] = $allMemes[$key];
}
?>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="css/style.css">
<main class="meme-feed">
    <div class="meme-grid">
        <?php foreach ($shuffledMemes as $meme): ?>
            <div class="meme-grid__item" data-meme-id="<?= $meme['is_sample'] ? 'sample' : $meme['id'] ?>">
                <?php 
                $username = $meme['is_sample'] ? 'Sample' : ($meme['username'] ?? 'Anonymous');
                renderCard($meme['image'], $meme['title'], $meme['likes'], $username); 
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<style>
/* Reset and base styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: #fafafa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    line-height: 1.5;
    color: #262626;
}

/* Meme feed layout */
.meme-feed {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 15px;
}

.meme-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    width: 100%;
}

.meme-grid__item {
    width: 100%;
    transition: transform 0.2s ease;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .meme-feed {
        max-width: 935px;
    }
}

@media (max-width: 1000px) {
    .meme-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 735px) {
    .meme-feed {
        padding: 0;
    }
    
    .meme-grid {
        gap: 0;
    }
    
    .meme-card {
        border-radius: 0;
        margin-bottom: 0;
        border-left: none;
        border-right: none;
    }
    
    .meme-card:not(:last-child) {
        border-bottom: 1px solid #dbdbdb;
    }
}

@media (max-width: 500px) {
    .meme-grid {
        grid-template-columns: 1fr;
    }
    
    .meme-card {
        border-radius: 0;
        margin-bottom: 0;
    }
}

/* Animation for grid items */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.meme-grid__item {
    animation: fadeIn 0.3s ease forwards;
    opacity: 0;
}

/* Stagger the animation for grid items */
.meme-grid__item:nth-child(1) { animation-delay: 0.1s; }
.meme-grid__item:nth-child(2) { animation-delay: 0.15s; }
.meme-grid__item:nth-child(3) { animation-delay: 0.2s; }
.meme-grid__item:nth-child(4) { animation-delay: 0.25s; }
.meme-grid__item:nth-child(5) { animation-delay: 0.3s; }
.meme-grid__item:nth-child(6) { animation-delay: 0.35s; }
</style>

<?php include './components/Footer.php'; ?>