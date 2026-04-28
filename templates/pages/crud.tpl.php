<?php
session_start();

$conn = new mysqli("localhost","feltalalok","feltalalok2026.","feltalalok");
$result = $conn->query("SELECT * FROM kutato ORDER BY fkod ASC");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kutatók CRUD</title>

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
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.25);
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">Kutatók adatai</h2>

<!-- HOZZÁADÁS FORM -->
<form method="post" action="/Feltalalokgyak/logicals/crud.php" style="width:80%; margin:auto;">
    <h3>Új kutató hozzáadása</h3>

    <label>Név:</label>
    <input type="text" name="nev" required>

    <label>Született:</label>
    <input type="number" name="szul">

    <label>Meghalt:</label>
    <input type="number" name="meghal">

    <button type="submit" name="add">Hozzáadás</button>
</form>

<br><br>

<table>
    <tr>
        <th>ID</th>
        <th>Név</th>
        <th>Születés</th>
        <th>Halál</th>
        <th>Művelet</th>
    </tr>

    <?php while ($a = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $a["fkod"] ?></td>
        <td><?= $a["nev"] ?></td>
        <td><?= $a["szul"] ?></td>
        <td><?= $a["meghal"] ?></td>
        <td>
            <!-- SZERKESZTÉS FORM -->
            <form method="post" action="/Feltalalokgyak/logicals/crud.php" style="display:inline;">
                <input type="hidden" name="fkod" value="<?= $a["fkod"] ?>">
                <input type="text" name="nev" value="<?= $a["nev"] ?>">
                <input type="number" name="szul" value="<?= $a["szul"] ?>">
                <input type="number" name="meghal" value="<?= $a["meghal"] ?>">
                <button type="submit" name="update">Mentés</button>
            </form>

            <!-- TÖRLÉS -->
            <a href="/Feltalalokgyak/logicals/crud.php?delete=<?= $a["fkod"] ?>"
               onclick="return confirm('Biztos törlöd?')">Törlés</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>

<?php $conn->close(); ?>
