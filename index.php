<?php
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/zedmemes-new/' :
        require __DIR__ . '/pages/home.php';
        break;
    case '/zedmemes-new/login' :
        require __DIR__ . '/pages/login.php';
        break;
    case '/zedmemes-new/signup' :
        require __DIR__ . '/pages/signup.php';
        break;
    case '/zedmemes-new/create_meme' :
        require __DIR__ . '/pages/create_meme.php';
        break;
    case '/zedmemes-new/my_memes' :
        require __DIR__ . '/pages/my_memes.php';
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
