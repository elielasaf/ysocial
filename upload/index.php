<?php
    session_start();
    require_once("../config/db.php");
    require_once("../config/functions/functions.php");
    date_default_timezone_set("America/Santo_Domingo");
    $date = getdate();

    if (!isset($_SESSION["AUTH"])) {
        header("Location: ../log/");
        exit;
    }

    if (isset($_POST["upload"])) {
        if (empty($_POST["title"]) || empty($_POST["desc"])) {
            $_SESSION["msg"] = "<p class='error'>Rellene los campos.</p>";
            header("Location: " . $_SERVER["REQUEST_URI"] . "");
            exit;
        }

        if ($_FILES["imagen"]["size"] == 0) {
            $datos = [
                "title" => $_POST["title"],
                "desc" => $_POST["desc"],
                "by" => $_SESSION["AUTH"]["id"]
            ];

            $_SESSION["msg"] = upload_post($datos, "nwf", $date);
            header("Location: ../");
            exit;
        } else {
            $datos = [
                "title" => $_POST["title"],
                "desc" => $_POST["desc"],
                "img" => base64_encode(file_get_contents($_FILES["imagen"]["tmp_name"])),
                "by" => $_SESSION["AUTH"]["id"]
            ];

            $_SESSION["msg"] = upload_post($datos, "wf", $date);
            header("Location: ../");
            exit;
        }
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
            <h1 class="title"><i class="fa-solid fa-images"></i>Haz una publicación</h1>
        </div>
        <div class="content">
            <form action="" method="post" class="formulario" enctype="multipart/form-data">
                <label for="title">Titulo de la publicación
                    <input type="text" name="title" id="title">
                </label>
                <label for="imagen">Subir imagen
                    <input type="file" name="imagen" id="imagen" accept=".png, .jpg, .jpeg">
                </label>
                <label for="desc">
                    <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
                </label>
                <?php
                    if (isset($_SESSION["msg"])) {
                        echo($_SESSION["msg"]);
                        unset($_SESSION["msg"]);
                    }
                ?>
                <div class="actions">
                    <button type="submit" name="upload">Publicar</button>
                    <a href="../">Cancelar</a>
                </div>
            </form>
            <!--<form action="" method="get">
                <button name="commet" value="1">
                    <i class="fa-solid fa-comment"></i>
                </button>
                <button name="like" value="1">
                    <i class="fa-solid fa-heart"></i>
                </button>
            </form>-->
        </div>
    </div>
</body>
</html>