<?php
include './components/Header.php';

require './components/homePage/Card.php';

// Sample meme data
$memes = [
    [
        'image' => 'https://i.imgflip.com/7b1bn9.jpg',
        'title' => 'Distracted Boyfriend',
        'likes' => 1243
    ],
    [
        'image' => 'https://i.imgflip.com/1h7in3.jpg',
        'title' => 'Batman Slapping Robin',
        'likes' => 876
    ],
    [
        'image' => 'https://i.imgflip.com/1g8my4.jpg',
        'title' => 'Drake Hotline Bling',
        'likes' => 2156
    ],
    [
        'image' => 'https://i.imgflip.com/9vct.jpg',
        'title' => 'Roll Safe',
        'likes' => 543
    ],
    [
        'image' => 'https://i.imgflip.com/1ihzfe.jpg',
        'title' => 'One Does Not Simply',
        'likes' => 1892
    ],
    [
        'image' => 'https://i.imgflip.com/1bij.jpg',
        'title' => 'Y U No',
        'likes' => 321
    ]
];
?>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="meme-feed">
    <div class="meme-grid">
        <?php foreach ($memes as $meme): ?>
            <div class="meme-grid__item">
                <?php renderCard($meme['image'], $meme['title'], $meme['likes']); ?>
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