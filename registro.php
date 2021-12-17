<?php
    /*
        @author: Sergio Matamoros Delgado <smatamorosdelgado.guadalupe@alumnado.fundacionloyola.net>
        @license: GPL v3 2021
        @description: BackEnd del minijuego de flashcards. 
        Permite registrarte en el sitio web.
    */
    require_once __DIR__."/clases/procesos.php";
    function crearCuenta() {
        if(isset($_POST["crear"])) {
            //Variables locales
            $user = $_POST["username"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $pw = $_POST["password"];
            $pw2 = $_POST["password2"];

            //Diferentes métodos para comprobar el email...
            /* SOLO FUNCIONA EN PHP 8
            if(str_starts_with($email, "@fundacionloyola.net")) {
                echo 'EMPIEZA';
            }*/
            /*if(strstr($email,"@") == "@fundacionloyola.net") {
                echo 'a';
            }*/
            $cache = null;
            for($i=0;$i<strlen($email);$i++) {
                if($email[$i] == "@") $cache.= substr($email,$i);
            }

            //Check correo
            if($cache == "@fundacionloyola.net") {

                //Comprobación contraseñas
                if($pw == $pw2) {

                    $db = new Procesos();

                    $insertDatos = $db->crearCuenta($user, $surname, $email, $pw);
                    //echo $insertDatos;

                    //Comprobaciones...
                    if($insertDatos == 1062) {
                        echo '
                        <div class="isa_error">
                            <i class="fa fa-times-circle"></i>
                            Se ha producido un error, ya existe una cuenta con ese nombre o correo.
                        </div>';
                    } else if($insertDatos == 1406) {
                        echo '
                        <div class="isa_error">
                            <i class="fa fa-times-circle"></i>
                            Se ha producido un error,la longitud de alguno de los campos es superior a la requerida.
                        </div>';
                    }else {
                        //Sesiones
                        session_start();
                        $_SESSION["id"] = $insertDatos;
                        $_SESSION["userName"] = $user;
                        $_SESSION["firstLogin"] = true;
                        //$_SESSION["tipoPerfil"] = $filaLogin["tipoPerfil"];

                        //Reedirigimos a la página principal.
                        //header("Location: index.php");
                        header("Location: estructura/preferencias.php");
                    }
                } else {
                    echo '
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i>
                        Se ha producido un error, las contraseñas no coinciden.
                    </div>';
                }
            } else {
                echo '
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i>
                        Se ha producido un error, el email no es válido.
                    </div>';
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
                        //preferencias();
                    ?>
                </form>
            </div>
        </div>-->
    </body>
</html>