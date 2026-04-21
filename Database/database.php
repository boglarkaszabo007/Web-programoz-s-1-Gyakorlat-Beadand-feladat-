<?php
$host = "localhost";
$user = "feltalalok";
$pass = "feltalalok2026.";
$db   = "feltalalok";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
?>