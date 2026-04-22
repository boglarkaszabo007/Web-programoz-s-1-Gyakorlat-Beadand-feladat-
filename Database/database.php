<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    // XAMPP
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "feltalalok";

} else {

    // Nethely
    $host = "localhost";
    $user = "feltalalok";
    $pass = "feltalalok2026.";
    $db   = "feltalalok";
}

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die($conn->connect_error);
}

?>