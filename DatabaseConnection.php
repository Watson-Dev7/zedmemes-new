<?php

function connection()
{
    $username="root";
    $password="";
    $database="imagedb";
    $server="localhost";
    $port="3307";

    $connect = new mysqli($server,$username,$password,$database,$port);

    if ($connect->connect_error)
{
    die("Connection error");
    echo "<p>Failed to Connect to database</p>";
}


 return $connect;

}

?>