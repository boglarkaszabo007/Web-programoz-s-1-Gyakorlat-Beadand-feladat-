<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uzenet = trim($_POST['uzenet'] ?? '');
    $errors = [];

    if ($uzenet === '' || mb_strlen($uzenet) < 5) {
        $errors[] = "Az üzenet legalább 5 karakter legyen.";
    }

    if (!empty($_SESSION['felhasznalo_id'])) {
        $uid = $_SESSION['felhasznalo_id'];
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
            $_SESSION['errors'] = ["Adatbázis hiba: " . $e->getMessage()];
        }

    } else {
        $_SESSION['errors'] = $errors;
    }

    header("Location: /Feltalalokgyak/kapcsolat");
    exit;
}