<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Üzenetek</title>

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
        color: black;
    }

    th {
        background-color: #cfe8ff;
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

<h2 align="center">Elküldött üzenetek</h2>

<table>

<tr>
    <th>Küldő</th>
    <th>Üzenet</th>
    <th>Küldés ideje</th>
</tr>

<?php if (!empty($uzenetek)): ?>

    <?php foreach($uzenetek as $uzenet): ?>

    <tr>
        <td><?= htmlspecialchars($uzenet['kuldo']) ?></td>
        <td><?= htmlspecialchars($uzenet['message']) ?></td>
        <td><?= htmlspecialchars($uzenet['created_at']) ?></td>
    </tr>

    <?php endforeach; ?>

<?php else: ?>

    <tr>
        <td colspan="3">Nincs még egyetlen üzenet sem.</td>
    </tr>

<?php endif; ?>

</table>

</body>
</html>