<?php
    session_start();
    require_once '../config/db.php';
    require_once '../config/functions/functions.php';

    if (!isset($_SESSION["AUTH"])) {
        header("Location: ../");
        exit;
    }

    if (isset($_GET["like-to"])) {
        add_like($_GET["like-to"], $_SESSION["AUTH"]["id"]);
    }

    if (isset($_GET["input-comment"])) {
        add_comment($_GET["input-comment"], intval($_GET["cmt"]), $_SESSION["AUTH"]["id"]);
        header("Location: index.php?order=DESC#" . $_GET['cmt'] . "");
        exit;
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
    
    if (!isset($_GET["order"])) {
        header("Location: " . $_SERVER["REQUEST_URI"] . "?order=DESC");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ysocial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/styles-home.css">
    <link rel="shortcut icon" href="../assets/img/logo.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="content">
            <?php
                if (isset($_SESSION["msg"])) {
                    echo($_SESSION["msg"]);
                    unset($_SESSION["msg"]);
                }
            ?>
            <div class="header">
                <h1 class="title">Bienvenido, <?= $_SESSION["AUTH"]["name"]; ?></h1>
                <img src="../assets/img/logo.png" alt="" width="60px">
                <a href="<?= $_SERVER["REQUEST_URI"] . "&logout"?>">Cerrar sesión</a>
            </div>
            <div class="posts-container">
                <div class="header-post-container">
                    <div class="options">
                        <form action="" method="get">
                            <p>Ver:
                            <?php
                                if ($_GET["order"] == "DESC") { ?>
                                    <button type="submit" name="order" value="ASC">Más antiguas</button>
                                <?php } else { ?>
                                    <button type="submit" name="order" value="DESC">Más recientes</button>
                                <?php }
                            ?></p>
                        </form>
                        <a href="../upload/" class="upload"><i class="fa-solid fa-upload"></i>Hacer una públicación</a>
                    </div>
                </div>
                <div class="posts-content">
                    <?php
                        get_posts($_GET["order"]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>