<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'test_db.php';

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css"
        crossorigin="anonymous">

    <link rel="stylesheet" href="zedmem.css">
    <link rel="stylesheet" href="reaction.css">
    <link rel="stylesheet" href="foundatiob\css\foundation.css">
    <link rel="stylesheet" href="foundatiob\css\main.css">

    <link rel="stylesheet" href="responsive.css">
</head>
<body>

