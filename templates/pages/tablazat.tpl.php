<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Táblázat</title>
</head>

<body>
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