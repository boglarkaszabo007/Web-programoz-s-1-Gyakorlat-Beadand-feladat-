<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Adatbázis kapcsolat
$dsn = "mysql:host=localhost;dbname=feltalalok;charset=utf8";
$user = "feltalalok";
$pass = "feltalalok2026.";

try {
    $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

// Művelet meghatározása
$action = $_GET["action"] ?? "";

// LISTÁZÁS
if ($action === "list") {
    $stmt = $db->query("SELECT * FROM kutato ORDER BY fkod ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// HOZZÁADÁS
if ($action === "add") {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $db->prepare("INSERT INTO kutato (nev, szul, meghal) VALUES (?, ?, ?)");
    $stmt->execute([
        $data["nev"],
        $data["szul"],
        $data["meghal"]
    ]);

    echo json_encode(["status" => "ok"]);
    exit;
}

// SZERKESZTÉS
if ($action === "update") {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $db->prepare("UPDATE kutato SET nev=?, szul=?, meghal=? WHERE fkod=?");
    $stmt->execute([
        $data["nev"],
        $data["szul"],
        $data["meghal"],
        $data["fkod"]
    ]);

    echo json_encode(["status" => "ok"]);
    exit;
}

// TÖRLÉS
if ($action === "delete") {
    $id = $_GET["fkod"] ?? 0;

    $stmt = $db->prepare("DELETE FROM kutato WHERE fkod=?");
    $stmt->execute([$id]);

    echo json_encode(["status" => "ok"]);
    exit;
}

// Ha semelyik action nem illik:
echo json_encode(["error" => "Invalid action"]);
exit;
