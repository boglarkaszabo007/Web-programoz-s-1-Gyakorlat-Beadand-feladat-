<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uzenet = trim($_POST['uzenet'] ?? '');
    $errors = [];

    if ($uzenet === '' || mb_strlen($uzenet) < 10) {
        $errors[] = "Az üzenet legalább 10 karakter legyen.";
    }

    // Felhasználó adatok
    if (isset($_SESSION['user'])) {
        $uid = $_SESSION['user']['id'];
    } else {
        $uid = null;
    }

    if (empty($errors)) {
        try {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=feltalalok;charset=utf8",
                "feltalalok",
                "feltalalok2026.",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $stmt = $pdo->prepare("
                INSERT INTO uzenetek (user_id, message, created_at)
                VALUES (:uid, :msg, NOW())
            ");

            $stmt->execute([
                ':uid' => $uid,
                ':msg' => $uzenet
            ]);

            $_SESSION['success'] = "Üzenet sikeresen elküldve.";

        } catch (PDOException $e) {
            $_SESSION['errors'] = ["Adatbázis hiba."];
        }

    } else {
        $_SESSION['errors'] = $errors;
    }

    // VISSZA A KAPCSOLAT OLDALRA
    header("Location: /Feltalalokgyak/kapcsolat");
    exit;
}
