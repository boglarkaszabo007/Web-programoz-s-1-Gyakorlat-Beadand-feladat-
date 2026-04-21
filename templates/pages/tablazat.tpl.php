<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Táblázat</title>
    <style>
        table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;

        background: transparent;

        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        border-radius: 8px;
        overflow: hidden;
        }

        th, td {
            border: 1px solid #bcd6ff;
            padding: 10px;
            text-align: center;
            color:black;
        }

        th {
            background-color: #cfe8ff;
            color: black;
        }

        tr {
            background-color: rgba(255, 255, 255, 0.15);
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.25);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transition: 0.2s;
        }
    </style>
</head>

<body>


<h2 style="text-align:center;">Kutato táblázat adatai</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Név</th>
        <th>Születés</th>
        <th>Halál</th>
    </tr>
    

    <?php foreach ($adatok as $a): ?>
        
    <tr>
        <td><?= $a["fkod"] ?></td>
        <td><?= $a["nev"] ?></td>
        <td><?= $a["szul"] ?></td>
        <td><?= $a["meghal"] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>