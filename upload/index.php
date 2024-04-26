<?php
    session_start();

    if (!isset($_SESSION["AUTH"])) {
        header("Location: ../log/");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hacer una públicación</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/styles-upload.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title"><i class="fa-solid fa-images"></i>Haz una publicacíón</h1>
        </div>
        <div class="content">
            <form action="" method="post" class="formulario">
                <label for="title">Titulo de la publicación
                    <input type="text" name="title" id="title">
                </label>
                <label for="imagen">Subir imagen
                    <input type="file" name="imagen" id="imagen">
                </label>
                <label for="desc">
                    <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
                </label>
                <div class="actions">
                    <button type="submit">Publicar</button>
                    <a href="../">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>