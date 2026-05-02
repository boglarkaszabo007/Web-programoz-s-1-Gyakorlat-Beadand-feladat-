<?php

try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=feltalalok;charset=utf8",
        "feltalalok",
        "feltalalok2026.",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $sql = "
        SELECT
            uzenetek.message,
            uzenetek.created_at,
            COALESCE(
                NULLIF(TRIM(CONCAT(felhasznalok.csaladi_nev, ' ', felhasznalok.uto_nev)), ''),
                'Vendég'
            ) AS kuldo
        FROM uzenetek
        LEFT JOIN felhasznalok
            ON uzenetek.user_id = felhasznalok.id
        ORDER BY uzenetek.created_at DESC
    ";

    $stmt = $conn->query($sql);
    $uzenetek = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Kapcsolati hiba: " . $e->getMessage());
}
?>