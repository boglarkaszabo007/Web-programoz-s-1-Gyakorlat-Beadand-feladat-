<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Főoldal</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        text-align: left;
        font-family: Arial;
        margin: 0;
        padding: 10px;
    }

    img {
    width: 80%;
    max-width: 700px;
    height: auto;
    border-radius: 10px;
    margin-top: 50px;
    margin-left: auto;
    margin-right: auto;
    }

    video {
        width: 90%;
        max-width: 750px;
        height: auto;
        border-radius: 10px;
        margin-top: 15px;
        margin-left: auto;
        margin-right: auto;
    }

    iframe {
        width: 50%;
        max-width: 800px;
        height: 450px;
        border-radius: 10px;
        margin-top: 15px;
        margin-left: auto;
        margin-right: auto;
    }
    .container {
        max-width: 1200px;
        margin: auto;
    }
    .box {
    flex: 1;
    }
    .row {
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: flex-start;
    margin-bottom: 20px;
    }
    @media (max-width: 700px) {
    .row {
        flex-direction: column;
    }
    }
</style>

<body>

<div class="container">
            <h2>Főoldal</h2>

    <div class="row">
        <div class="box">
            <h2>Saját videó</h2>
            <video controls>
                <source src="./videos/wizzair.mp4" type="video/mp4">
            </video>
        </div>

        <div class="box">
            <img src="./images/feltalalok.jpg">
        </div>
    </div>

    <h2>YouTube videó</h2>
    <iframe src="https://www.youtube.com/embed/FWwiAloY80k" allowfullscreen></iframe>

    <h2>Google Térkép</h2>
    <iframe src="https://www.google.com/maps?q=Budapest&output=embed" allowfullscreen></iframe>

</div>

</body>
</html>