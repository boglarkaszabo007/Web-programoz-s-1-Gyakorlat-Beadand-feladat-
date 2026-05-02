<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['felhasznalo_id']);
?>

<style>
.contact-card {
    width: 100%;
    max-width: 400px;
    margin: 30px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    box-sizing: border-box;
}

.contact-card textarea {
    width: 100%;
    box-sizing: border-box;
}

.contact-card h2 {
    text-align: center;
    margin-bottom: 15px;
}

.contact-card textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    resize: none;
}

.contact-card button {
    width: 100%;
    padding: 10px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.contact-card button:hover {
    background-color: #2980b9;
}

.error-box {
    background-color: #ffe6e6;
    color: #c0392b;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
}

.success-box {
    background-color: #eafaf1;
    color: #27ae60;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
}

@media (max-width: 480px) {
    .contact-card {
        max-width: 100%;
        padding: 15px;
        margin: 20px auto;
    }

    .contact-card h2 {
        font-size: 22px;
    }

    .contact-card button {
        font-size: 15px;
    }
}
</style>

<h2>Adatok:</h2>
<p>Ügyvezető: <strong>Weboldal készítői</strong></p>
<p>E-mail: <strong>nemlétezik2026@gmail.com</strong></p>

<hr>

<div class="contact-card">

    <h2>Kapcsolatfelvétel</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success-box">
            Üzenet sikeresen elküldve.
        </div>
    <?php endif; ?>

    <?php if ($loggedIn): ?>
        <p style="text-align:center;">
            Bejelentkezve mint:
            <strong><?= htmlspecialchars($_SESSION['csn'] . " " . $_SESSION['un']) ?></strong>
        </p>
    <?php else: ?>
        <p style="text-align:center;">
            <strong>Vendégként küldesz üzenetet.</strong>
        </p>
    <?php endif; ?>

    <form id="kapcsolatForm" method="post" action="/Feltalalokgyak/logicals/kapcsolat.php">

        <label for="uzenet">Üzenet:</label><br><br>

        <textarea name="uzenet" id="uzenet" rows="5"></textarea>

        <br><br>

        <button type="submit">Küldés</button>
    </form>

</div>

<hr>

<div style="text-align:center;">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2726.3375296155727!2d19.66695091525771!3d46.89607994478184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4743da7a6c479e1d%3A0xc8292b3f6dc69e7f!2sPallasz+Ath%C3%A9n%C3%A9+Egyetem+GAMF+Kar!5e0!3m2!1shu!2hu!4v1475753185783"
        width="600" height="450" frameborder="0" style="border:0" allowfullscreen>
    </iframe>

    <br>

    <a target="_blank"
       href="https://www.google.hu/maps/place/Pallasz+Ath%C3%A9n%C3%A9+Egyetem+GAMF+Kar/@46.8960799,19.6669509,17z/data=!3m1!4b1!4m5!3m4!1s0x4743da7a6c479e1d:0xc8292b3f6dc69e7f!8m2!3d46.8960763!4d19.6691396?hl=hu">
        Nagyobb térkép
    </a>
</div>

<script>
document.getElementById("kapcsolatForm").addEventListener("submit", function(e) {
    let uzenet = document.getElementById("uzenet").value.trim();
    let errors = [];

    if (uzenet.length < 5)
        errors.push("Az üzenet legalább 5 karakter legyen.");

    if (errors.length > 0) {
        e.preventDefault();
        alert(errors.join("\n"));
    }
});
</script>