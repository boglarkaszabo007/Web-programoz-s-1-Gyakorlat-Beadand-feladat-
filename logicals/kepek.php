<?php
session_start();

try
{
$dbh = new PDO(
'mysql:host=localhost;dbname=feltalalok',
'feltalalok',
'feltalalok2026.',
array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)
);

if(isset($_FILES['kep']) && $_FILES['kep']['error'] === 0)
{
    $fajlnev = time() . "_" . $_FILES['kep']['name'];

    move_uploaded_file(
        $_FILES['kep']['tmp_name'],
        __DIR__ . '/../uploads/' . $fajlnev
    );

$sql = "
INSERT INTO kepek
(fajlnev, felhasznalo_id)
VALUES
(:fajlnev, :uid)
";

$stmt = $dbh->prepare($sql);

$stmt->execute(array(
':fajlnev' => $fajlnev,
':uid' => $_SESSION['felhasznalo_id']
));

echo "Sikeres feltöltés";
}

}
catch(PDOException $e)
{
echo $e->getMessage();
}
?>