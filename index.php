<?php
    session_start();

    if (isset($_SESSION["AUTH"])) {
        header("Location: home/");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Social</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
    <div class="container">
        <div class="content-nouser">
            <h1 class="title">Bienvenido a Y.social</h1>
            <p class="info">Para acceder al contenido de Y.social, por favor, inicie sesion o registrese.</p>
            <div class="actions">
                <a href="log/" class="login">Ingresar</a>
            </div>
        </div>
    </div>
</body>
</html>