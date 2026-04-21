<?php
include('./includes/config.inc.php');

/* routing */
$oldal = $_SERVER['QUERY_STRING'];

if ($oldal != "") {
    if (isset($oldalak[$oldal]) && file_exists("./templates/pages/{$oldalak[$oldal]['fajl']}.tpl.php")) {
        $keres = $oldalak[$oldal];
    } else {
        $keres = $hiba_oldal;
        header("HTTP/1.0 404 Not Found");
    }
} else {
    $keres = $oldalak['/'];
}

/* DB */
include "Database/database.php";

$sql = "SELECT * FROM kutato";
$result = $conn->query($sql);

$adatok = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $adatok[] = $row;
    }
}

/* FONTOS: EZ KELL VISSZA */
include "templates/index.tpl.php";
?>