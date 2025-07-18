<?php
include './components/Header.php';
include './components/NavBar.php';
require './components/homePage/Card.php';

// Sample meme data
$memes = [
    [
        'image' => 'https://via.placeholder.com/300x180?text=Meme+1',
        'title' => 'Meme One',
        'likes' => 12
    ],
    [
        'image' => 'https://via.placeholder.com/300x180?text=Meme+2',
        'title' => 'Meme Two',
        'likes' => 34
    ],
    [
        'image' => 'https://via.placeholder.com/300x180?text=Meme+3',
        'title' => 'Meme Three',
        'likes' => 7
    ]
];
?>

<div class="memeContainer container">
    <?php
    foreach ($memes as $meme) {
      renderCard($meme['image'], $meme['title'], $meme['likes']);
    }
    ?>
</div>

<?php include './components/Footer.php'; ?>