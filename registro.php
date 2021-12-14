<?php
    require_once __DIR__."/clases/procesos.php";
    function crearCuenta() {
        if(isset($_POST["crear"])) {
            //Variables locales
            $user = $_POST["username"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $pw = $_POST["password"];
            $pw2 = $_POST["password2"];

            //Comprobación contraseñas
            if($pw == $pw2) {

                $db = new Procesos();

                $insertDatos = $db->crearCuenta($user, $surname, $email, $pw);
                //echo $insertDatos;

                //Sesiones
                session_start();
                $_SESSION["id"] = $insertDatos;
                $_SESSION["firstLogin"] = true;
                //$_SESSION["tipoPerfil"] = $filaLogin["tipoPerfil"];

                //Reedirigimos a la página principal.
                //header("Location: index.php");
                header("Location: estructura/preferencias.php");
            } else {
                echo 'Las contraseñas NO coinciden';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creación de cuenta</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/estilo.css">
    </head>
    <body>
        <div id="cajaMainRegister">
            <p><span>Flash</span>Cards</p>
            <div id="cajaRegister">
                <form action="#" method="post">
                    <h2>Creación de cuenta</h2>
                    <label for="username"><i class="fas fa-user"></i></label>
                    <input type="text" name="username" id="username" placeholder="Nombre" required>
                    <label for="username"><i class="fas fa-user"></i></label>
                    <input type="text" name="surname" id="surname" placeholder="Apellido" required>

                    <label for="username"><i class="fas fa-envelope"></i></label>
                    <input type="text" name="email" id="email" placeholder="Correo" required>

                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" name="password2" id="password2" placeholder="Repetir contraseña" required>
                    <input type="submit" value="Crear cuenta" name="crear[]">
                    
                    <span>¿Tienes una cuenta? Click <a href="login.php"> aquí</a></span>
                </form>
                <?php
                    crearCuenta();
                ?>
            </div>
        </div>
        <!--<div id="cajaMainRegister">
            <p><span>Flash</span>Cards</p>
            <div id="cajaPreferencias">
                <form action="#" method="post">
                    <h2>Selección de preferencias</h2>
                    <?php
                        preferencias();
                    ?>
                </form>
            </div>
        </div>-->
    </body>
</html>