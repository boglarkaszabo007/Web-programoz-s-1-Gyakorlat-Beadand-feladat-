<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Táblázat</title>
</head>

<body>
<style>
    .view-table {
    border-collapse: collapse !important;
    width: 80% !important;
    margin: 20px auto !important;
    background: transparent !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12) !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    }

    .view-table th,
    .view-table td {
        border: 1px solid #bcd6ff !important;
        padding: 10px !important;
        text-align: center !important;
        color: black !important;
    }

    .view-table th {
        background-color: #cfe8ff !important;
    }

    .view-table tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }

    .view-table tr:hover {
        background-color: rgba(255, 255, 255, 0.4) !important;
        transition: 0.2s;
    }

</style>

<h2 style="text-align:center;">Kutato táblázat adatai</h2>

<table class ="view-table">
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