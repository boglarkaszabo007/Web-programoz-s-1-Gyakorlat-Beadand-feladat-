<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('./includes/config.inc.php');

/* routing */
// 1. Kinyerjük a kulcsot a query stringből (pl. "crud")
$oldal = $_SERVER['QUERY_STRING'];

// 2. Ha van benne egyéb paraméter (pl. &error=1), azt levágjuk, hogy csak a kulcs maradjon
if (($pos = strpos($oldal, '&')) !== false) {
    $oldal = substr($oldal, 0, $pos);
}

// 3. Tisztítás (perjelek eltávolítása)
$oldal = trim($oldal, '/');

if ($oldal != "") {
    // Itt történik az ellenőrzés a config.inc.php tömbje alapján
    if (isset($oldalak[$oldal]) && file_exists("./templates/pages/{$oldalak[$oldal]['fajl']}.tpl.php")) {
        $keres = $oldalak[$oldal];
    } else {
        // Debug tipp: ha nem találja, írasd ki ideiglenesen: die("Nem találtam: " . $oldal);
        $keres = $hiba_oldal;
        header("HTTP/1.0 404 Not Found");
    }
} else {
    $keres = $oldalak['/'];
}

/* DB */
include "Database/database.php";

$sql = "SELECT * FROM kutato";
$adatok = [];

try {
    // PDO esetén a query() egy PDOStatement objektumot ad vissza
    $result = $conn->query($sql);

    if ($result) {
        // fetchAll-t használunk, mert PDO-ról van szó
        $adatok = $result->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // Ha hiba van a lekérdezésben, itt elkaphatod
    $hiba_uzenet = $e->getMessage();
}

/* FONTOS: EZ KELL VISSZA */
include "templates/index.tpl.php";
