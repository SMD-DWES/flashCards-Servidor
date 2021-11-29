<?php
    /*
        @author: Sergio Matamoros Delgado <smatamorosdelgado.guadalupe@alumnado.fundacionloyola.net>
        @license: GPL v3 2021
        @description: BackEnd del minijuego de flashcards. 
        Se encarga de insertar los puntos en el top 10 puntuaciones de la B.D.
    */
    require __DIR__."/clases/procesos.php";

    //FORMULARIO QUE PIDA LOS PUNTOS A INSERTAR
    if(isset($_POST["enviar"])) {

        $puntos = $_POST["iPuntos"];

        $bd = new Procesos();

        //Seleccionamos el top 10 (este se podría hacer con un * no es necesario el top.)
        $puntosOk = $bd->seleccionar("order by puntuacion desc limit 1");

        //Seleccionamos el top 10 de partidas, pero con la puntuación más baja
        $minPuntos = $bd->seleccionar("idPartida, puntuacion","WHERE puntuacion = (SELECT MIN(puntuacion) FROM partidas)");

        //$fila = $bd->selectArray($puntosOk,MYSQLI_ASSOC);//quitar

        $filaPuntosMin = $bd->selectArray($minPuntos,MYSQLI_ASSOC);

        //print_r($fila);

        //Boolean que indica si has sido aceptado o no.
        $aceptado = false;
        //Mensaje personalizado para el usuario
        $mensaje = "";

        //Compruebo que si no hay 10 filas, añado el resultado directamente (y evito numeros negativos y 0).
        if($bd->num_Filas($puntosOk) < 10 && $puntos > 0) {
            echo '[debug, añado una nueva puntuación]';

            //Insertamos en la B.D los puntos nuevos.
            $bd->insertarDatos(1,1,$puntos);

            //Establecemos que el usuario ha entrado en el top10
            $aceptado = true;
        //
        } else if($puntos > $filaPuntosMin["puntuacion"]) {
            echo 'tus puntos son mayores que los de la bd<br>';

            
            //debug
            echo '[Debug] puntuaciones llena, actualizo.<br>';
            
            print_r($filaPuntosMin);

            echo "Puntuacion minima recogida: ". $filaPuntosMin["puntuacion"] . " con id: ". $filaPuntosMin["idPartida"];

            //Modifico los valores en la B.D.
            $bd->modificar($puntos, $filaPuntosMin["idPartida"]);

            //Establecemos que el usuario ha entrado en el top10
            $aceptado = true;

        } else {
            $aceptado = false;
        }
        echo ($aceptado) ? $mensaje = '<br>¡Tu puntuación ha entrado en el top 10!' : $mensaje = '<br>No has entrado en el top 10 :(';

        echo '<br>Tus puntos: '.$puntos;
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Puntos</title>
    </head>
    <body>
        <form action="#" method="post">
            <input type="number" name="iPuntos" id="">
            <input type="submit" value="Enviar" name="enviar[]">
        </form>
    </body>
</html>