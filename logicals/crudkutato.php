<?php
session_start();

$conn = new mysqli("localhost","feltalalok","feltalalok2026.","feltalalok");

if ($conn->connect_error) {
    die("Kapcsolati hiba");
}

// HOZZÁADÁS
if (isset($_POST["add"])) {
    $nev = $_POST["nev"];
    $szul = $_POST["szul"];
    $meghal = $_POST["meghal"];

    $stmt = $conn->prepare("INSERT INTO kutato (nev, szul, meghal) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nev, $szul, $meghal);
    $stmt->execute();
    $stmt->close();

    header("Location: /Feltalalokgyak/crud");
    exit;
}

// SZERKESZTÉS
if (isset($_POST["update"])) {
    $fkod = $_POST["fkod"];
    $nev = $_POST["nev"];
    $szul = $_POST["szul"];
    $meghal = $_POST["meghal"];

    $stmt = $conn->prepare("UPDATE kutato SET nev=?, szul=?, meghal=? WHERE fkod=?");
    $stmt->bind_param("siii", $nev, $szul, $meghal, $fkod);
    $stmt->execute();
    $stmt->close();

    header("Location: /Feltalalokgyak/crud");
    exit;
}

// TÖRLÉS
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $stmt = $conn->prepare("DELETE FROM kutato WHERE fkod=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: /Feltalalokgyak/crud");
    exit;
}

$conn->close();
