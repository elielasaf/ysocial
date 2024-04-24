<?php
    session_start();
    require_once("../config/db.php");

    if (isset($_POST["name-r"])) {
        if (empty($_POST["name-r"]) || empty($_POST["email-r"]) || empty($_POST["password-r"])) {
            $_SESSION["msg"] = "<p class='error'>Rellene todos los campos.</p>";
            header("Location: " . $_SERVER["REQUEST_URI"] . "");
            exit;
        } elseif (!filter_var($_POST["email-r"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["msg"] = "<p class='error'>Ingrese un correo valido.</p>";
            header("Location: " . $_SERVER["REQUEST_URI"] . "");
            exit;
        } else {
            $insert = $db -> prepare("INSERT INTO users(user_nombre, user_correo, user_contraseña) VALUES(:nm, :em, :pw)");
            $insert -> execute(array(
                ':nm' => htmlentities($_POST["name-r"]),
                ':em' => $_POST["email-r"],
                ':pw' => hash("MD5", $_POST["password-r"])
            ));

            $_SESSION["msg"] = "<p class='error'>Registro exitoso, inicie sesion.</p>";
            header("Location: " . $_SERVER["REQUEST_URI"] . "");
            exit;
        }
    } elseif (isset($_POST["email-l"])) {
        if (empty($_POST["email-l"]) || empty($_POST["password-l"])) {
            $_SESSION["msg"] = "<p class='error'>Rellene todos los campos.</p>";
            header("Location: " . $_SERVER["REQUEST_URI"] . "");
            exit;
        } else {
            $get = $db -> prepare("SELECT * FROM users WHERE user_correo = :em AND user_contraseña = :pw");
            $get -> execute(array(
                ':em' => $_POST["email-l"],
                ':pw' => hash("MD5", $_POST["password-l"])
            ));

            if ($get -> rowCount() < 1) {
                $_SESSION["msg"] = "<p class='error'>Correo o contraseña incorrectos.</p>";
                header("Location: " . $_SERVER["REQUEST_URI"] . "");
                exit;
            } else {
                $datos = $get -> fetch(PDO::FETCH_ASSOC);

                $_SESSION["AUTH"] = [
                    "id" => $datos["user_id"],
                    "name" => $datos["user_nombre"],
                    "email" => $datos["user_correo"],
                ];

                header("Location: ../");
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" />
    <title>Formulario de registro</title>
  </head>
  <body>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para unirte a nuestra comunidad por favor inicia Sesion con tus datos</p>
                <input type="button" value="Iniciar Sesion" id="sign-in">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una Cuenta</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                    <i class='bx bxl-github'></i>
                    <i class='bx bxl-linkedin'></i>
                </div>
                <p>o usa tu email para registrarte</p>
                <form class="form" method="POST"> 
                    <label>
                        <i class='bx bx-user'></i>
                        <input type="text" name="name-r" placeholder="Nombre de Usuario">
                    </label>
                    <label>
                        <i class='bx bx-envelope' ></i>
                        <input type="email" name="email-r" placeholder="Correo Electronico">
                    </label>
                    <label>
                        <i class='bx bx-lock-alt' ></i>
                        <input type="password" name="password-r" placeholder="Contraseña">
                    </label>
                    <input type="submit" value="Registrarse">
                    <?php
                        if (isset($_SESSION["msg"])) {
                            echo($_SESSION["msg"]);
                            unset($_SESSION["msg"]);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>





    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡¡Bienvenido nuevamente!!</h2>
                <p>Para unirte a nuestra comunidad por favor inicia Sesion con tus datos</p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesion</h2>
                <div class="icons">
                    <i class='bx bxl-google'></i>
                    <i class='bx bxl-github'></i>
                    <i class='bx bxl-linkedin'></i>
                </div>
                <p>o Iniciar Sesion con una cuenta</p>
                <form class="form" method="POST"> 
                   
                    <label>
                        <i class='bx bx-envelope' ></i>
                        <input type="email" name="email-l" placeholder="Correo Electronico">
                    </label>
                    <label>
                        <i class='bx bx-lock-alt' ></i>
                        <input type="password" name="password-l" placeholder="Contraseña">
                    </label>
                    <input type="submit" value="Iniciar Sesion">
                    <?php
                        if (isset($_SESSION["msg"])) {
                            echo($_SESSION["msg"]);
                            unset($_SESSION["msg"]);
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
  </body>
</html>