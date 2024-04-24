<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Social</title>
</head>
<body>
    <div class="container">
        <?php
            if (isset($_SESSION["AUTH"])) { ?>
                <div class="content">
                    <h1 class="title">Bienvenido</h1>
                </div>  
            <?php } else { ?>
                <div class="content-nouser">
                    <h1 class="title">Bienvenido a Red Social</h1>
                    <p class="info">Para acceder al contenido de este sitio, por favor, inicie sesion o registrese.</p>
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