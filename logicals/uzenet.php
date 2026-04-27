<?php
session_start();

$conn = new mysqli("localhost","feltalalok","feltalalok2026.","feltalalok");

if($conn->connect_error)
{
    die("Kapcsolati hiba");
}

$sql = "SELECT
        uzenetek.message,
        uzenetek.created_at,
        COALESCE(CONCAT(felhasznalok.csaladi_nev, ' ', felhasznalok.uto_nev), 'Vendég') AS kuldo
        FROM uzenetek
        LEFT JOIN felhasznalok
        ON uzenetek.user_id = felhasznalok.id
        ORDER BY uzenetek.created_at DESC";
        
$result = $conn->query($sql);

$uzenetek = array();

while($row = $result->fetch_assoc())
{
    $uzenetek[] = $row;
}

$conn->close();

include("uzenetek.tpl.php");
?>