<?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<h1>Kilépett:</h1>
<?= $data['csn']." ".$data['un']." (".$data['login'].")" ?>
