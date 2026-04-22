<?php
session_start();

$loggedIn = isset($_SESSION['felhasznalo_id']);

$dbh = new PDO(
    'mysql:host=localhost;dbname=feltalalok',
    'feltalalok',
    'feltalalok2026.'
);
?>

<!-- 🔝 FELTÖLTÉS FELÜL -->
<?php if($loggedIn): ?>
<style>
   .upload-box {
    display: flex;
    gap: 10px;
    align-items: center;
    background: #eaf4ff;
    padding: 12px;
    border-radius: 10px;
    width: fit-content;
    margin-bottom: 15px;
    }
    .upload-box input[type="file"] {
        background: white;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
    .upload-box button {
        background-color: #2d6cdf;
        color: white;
        border: none;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
    }

    .upload-box button:hover {
        background-color: #1f4fb3;
    }
</style>

<form action="/Feltalalokgyak/logicals/kepek.php"
      method="post"
      enctype="multipart/form-data">

    <div class="upload-box">
        <input type="file" name="kep">
        <button type="submit">Feltöltés</button>
    </div>

</form>

<?php else: ?>

<div style="color:red;">
    Csak bejelentkezett felhasználók tölthetnek fel képet.
</div>

<?php endif; ?>

<hr>

<!-- 📷 KÉPEK LISTÁJA -->
<?php
$sql = "SELECT fajlnev FROM kepek";
$stmt = $dbh->query($sql);

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<img src='/Feltalalokgyak/uploads/".$row['fajlnev']."' width='200'>";
}
?>