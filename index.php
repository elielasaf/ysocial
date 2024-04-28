<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Social</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/styles-home.css">
</head>
<body>
    <div class="container">
        <?php
            if (isset($_SESSION["AUTH"])) { ?>
                <div class="content">
                    <?php
                        if (isset($_SESSION["msg"])) {
                            echo($_SESSION["msg"]);
                            unset($_SESSION["msg"]);
                        }
                    ?>
                    <h1 class="title">Bienvenido, <?= $_SESSION["AUTH"]["name"]; ?></h1>
                    <div class="posts-container">
                        <div class="header-post-container">
                            <h2 class="title"><i class="fa-solid fa-images"></i>Publicaciones realizadas</h2>
                            <a href="upload/" class="upload"><i class="fa-solid fa-upload"></i>Hacer una públicación</a>
                        </div>
                        <div class="posts-content">
                            <?php
                                
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="content-nouser">
                    <h1 class="title">Bienvenido a [Nombre]</h1>
                    <p class="info">Para acceder al contenido de [Nombre], por favor, inicie sesion o registrese.</p>
                    <div class="actions">
                        <a href="log/?login" class="login">Iniciar sesion</a>
                        <a href="log/?register" class="register">Registrarme</a>
                    </div>
                </div>
            <?php }
        ?>
    </div>
</body>
</html>