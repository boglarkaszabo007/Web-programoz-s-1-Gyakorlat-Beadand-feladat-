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

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass,
                            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $conn->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
} catch(Exception $e) {
    die("Adatbázis hiba: " . $e->getMessage());
}

?>