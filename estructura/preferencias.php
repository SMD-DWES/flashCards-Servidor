<?php
    /*
        @author: Sergio Matamoros Delgado <smatamorosdelgado.guadalupe@alumnado.fundacionloyola.net>
        @license: GPL v3 2021
        @description: BackEnd del minijuego de flashcards. 
        Se encarga de que el usuario pueda elegir que tipo de minijuegos le gusta más.
    */
    require_once dirname(__DIR__, 1)."../clases/procesos.php";
    function preferencias() {
        $db = new Procesos();


        $selMinijuegos = $db->seleccionar("SELECT * FROM minijuegos");

        echo "
        <form action='#' method='POST'>
        ";

        foreach ($selMinijuegos as $valor) {
            echo
            "
                <label for='$valor[nombre]'> $valor[nombre]</label>
                <input type='checkbox' id='$valor[nombre]' name='minijuegoChx[]' value='$valor[idMinijuego]' />
            ";
        }
        echo "
            <input type='submit' value='Enviar' name='sendPreferencias[]'>
        </form>
        ";
    }

    

    if(isset($_POST["sendPreferencias"])) {
        if(isset($_POST["minijuegoChx"])) {

           //Iniciamos la sesión para recoger la id del usuario.
            session_start();
            $idUser = $_SESSION["id"];

            $db = new Procesos();
            

            foreach ($_POST["minijuegoChx"] as $valor) {
                $db->insertarDatos("INSERT INTO preferencias(idUsuario, idMinijuego) VALUES($idUser, $valor);");
            }

            //Reedirigir al index.
            header("Location: ../index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PREFERENCIAS</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="../css/estilo.css">
    </head>
    <body>
        <div id="cajaMainRegister">
            <p><span>Flash</span>Cards</p>
            <div id="cajaPreferencias">
                <form action="#" method="post">
                    <h2>Selección de preferencias</h2>
                    <?php
                        preferencias();
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>