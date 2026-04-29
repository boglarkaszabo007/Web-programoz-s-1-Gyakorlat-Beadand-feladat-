<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . "/../Database/database.php";
header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            $Result = $conn->query("SELECT * FROM kutato");
            echo json_encode([
                'Hiba' => null,
                'Kutatok' => $Result->fetchAll(PDO::FETCH_ASSOC)
            ]);
        } catch (Exception $e) {
            echo json_encode(['Hiba' => 'Sikertelen adat lekérés!']);
        }
        break;

    case 'POST':
        $NewInventor = !empty($_POST) ? $_POST : json_decode(file_get_contents("php://input"), true);
        
        if (empty($NewInventor['nev']) || empty($NewInventor['szul'])) {
            header("Location: ../index.php?crud&error=hianyos_adatok");
            exit(); 
        }

        try {
            if (!empty($NewInventor['fkod'])) {
                // UPDATE (Módosítás)
                $Statment = $conn->prepare("UPDATE kutato SET nev = :nev, szul = :szul, meghal = :meghal WHERE fkod = :fkod");
                $Statment->execute([
                    'nev' => $NewInventor['nev'],
                    'szul' => $NewInventor['szul'],
                    'meghal' => $NewInventor['meghal'],
                    'fkod' => $NewInventor['fkod']
                ]);
            } else {
                // INSERT (Új felvétel)
                $Statment = $conn->prepare("INSERT INTO kutato(nev, szul, meghal) VALUES(:nev, :szul, :meghal)");
                $Statment->execute([
                    'nev' => $NewInventor['nev'],
                    'szul' => $NewInventor['szul'],
                    'meghal' => $NewInventor['meghal']
                ]);
            }
        } catch (Exception $e) {
            header("Location: ../index.php?crud&error=adatbazis_hiba");
            exit();
        }
        header("Location: ../index.php?crud"); 
        exit();

    case 'DELETE':
        $Data = json_decode(file_get_contents("php://input"), true);
        // Itt az 'id' kulcsot kell ellenőrizni!
        if (!isset($Data['id']) || empty($Data['id'])) {
            echo json_encode(['Hiba' => 'Hiányos azonosító a törléshez!']);
            exit;
        }
        try {
            $Statment = $conn->prepare("DELETE FROM kutato WHERE fkod = :id");
            $Statment->execute(['id' => $Data['id']]);
            echo json_encode(['Hiba' => null]);
        } catch (Exception $e) {
            echo json_encode(['Hiba' => 'Sikertelen törlés az adatbázisból!']);
        }
        break;
    case 'PUT':
        $InventorUpdate = json_decode(file_get_contents("php://input"), true);
        if (
            !isset($InventorUpdate['id'], $InventorUpdate['nev'], $InventorUpdate['szul'], $InventorUpdate['meghal']) ||
            empty($InventorUpdate['id']) || empty($InventorUpdate['nev']) ||
            empty($InventorUpdate['szul']) || empty($InventorUpdate['meghal'])
        ) {
            echo json_encode(['Hiba' => 'Hiányos adatok!']);
            exit;
        }
        try {
            $Statment = $conn->prepare("UPDATE kutato SET
                                                nev = :nev,
                                                szul = :szul,
                                                meghal = :meghal
                                            WHERE fkod = :id");
            $Statment->execute([
                'id' => $InventorUpdate['id'],
                'nev' => $InventorUpdate['nev'],
                'szul' => $InventorUpdate['szul'],
                'meghal' => $InventorUpdate['meghal']
            ]);
            echo json_encode([
                'Hiba' => null
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'Hiba' => 'Sikertelen módosítás!'
            ]);
        }
        break;
    default:
        echo json_encode([
            'Hiba' => 'Nem támogatott kérés!'
        ]);
        break;
}
