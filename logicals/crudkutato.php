<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . "/../Database/database.php";

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        header('Content-Type: application/json');

        try {
            $Result = $conn->query("SELECT * FROM kutato");
            $Kutatok = $Result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($Kutatok as &$row) {
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $row[$key] = "";
                    }
                }
            }

            echo json_encode([
                'Hiba' => null,
                'Kutatok' => $Kutatok
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'Hiba' => 'Sikertelen adat lekérés! ' . $e->getMessage()
            ]);
        }
        break;


    case 'POST':
        $NewInventor = $_POST;

        if (empty($NewInventor['nev'])) {
            header("Location: /Feltalalokgyak/index.php?crud&error=nev_hiany");
            exit;
        }

        $szul   = !empty($NewInventor['szul']) ? (int)$NewInventor['szul'] : null;
        $meghal = !empty($NewInventor['meghal']) ? (int)$NewInventor['meghal'] : null;

        if ($szul !== null && !preg_match('/^\d{4}$/', (string)$szul)) {
            header("Location: /Feltalalokgyak/index.php?crud&error=szul_format");
            exit;
        }

        if ($meghal !== null && !preg_match('/^\d{4}$/', (string)$meghal)) {
            header("Location: /Feltalalokgyak/index.php?crud&error=meghal_format");
            exit;
        }

        if ($szul !== null && $meghal !== null && $szul > $meghal) {
            header("Location: /Feltalalokgyak/index.php?crud&error=ev_logika");
            exit;
        }

        try {
            if (!empty($NewInventor['fkod'])) {

                $Statement = $conn->prepare("
                    UPDATE kutato 
                    SET nev = :nev, szul = :szul, meghal = :meghal 
                    WHERE fkod = :fkod
                ");

                $Statement->execute([
                    'nev' => $NewInventor['nev'],
                    'szul' => $szul,
                    'meghal' => $meghal,
                    'fkod' => $NewInventor['fkod']
                ]);

            } else {

                $Statement = $conn->prepare("
                    INSERT INTO kutato(nev, szul, meghal) 
                    VALUES(:nev, :szul, :meghal)
                ");

                $Statement->execute([
                    'nev' => $NewInventor['nev'],
                    'szul' => $szul,
                    'meghal' => $meghal
                ]);
            }

        } catch (Exception $e) {
            header("Location: /Feltalalokgyak/index.php?crud&error=adatbazis");
            exit;
        }

        header("Location: /Feltalalokgyak/index.php?crud");
        exit;


    case 'DELETE':
        header('Content-Type: application/json');

        $Data = json_decode(file_get_contents("php://input"), true);

        if (!isset($Data['id']) || empty($Data['id'])) {
            echo json_encode([
                'Hiba' => 'Hiányos azonosító a törléshez!'
            ]);
            exit;
        }

        try {
            $Statement = $conn->prepare("
                DELETE FROM kutato 
                WHERE fkod = :id
            ");

            $Statement->execute([
                'id' => $Data['id']
            ]);

            echo json_encode([
                'Hiba' => null
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'Hiba' => 'Sikertelen törlés az adatbázisból! ' . $e->getMessage()
            ]);
        }
        break;


    default:
        header('Content-Type: application/json');

        echo json_encode([
            'Hiba' => 'Nem támogatott kérés!'
        ]);
        break;
}