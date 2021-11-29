<?php
    require __DIR__."/clases/procesos.php";

    //FORMULARIO QUE PIDA LOS PUNTOS A INSERTAR
    if(isset($_POST["enviar"])) {

        $puntos = $_POST["iPuntos"];

        $bd = new Procesos();

        //Seleccionamos el top 10 (este se podría hacer con un * no es necesario el top.)
        $puntosOk = $bd->seleccionar("order by puntuacion desc limit 10");

        //Seleccionamos el top 10 de partidas, pero con la puntuación más baja
        $minPuntos = $bd->seleccionar("idPartida, puntuacion","WHERE puntuacion = (SELECT MIN(puntuacion) FROM partidas)");

        $fila = $bd->selectArray($puntosOk,MYSQLI_ASSOC);//quitar

        $filaPuntosMin = $bd->selectArray($minPuntos,MYSQLI_ASSOC);

        print_r($fila);

        //while($fila = $bd->selectArray($puntosOk,MYSQLI_ASSOC)) {
            if($puntos > $fila["puntuacion"]) {
                echo 'tus puntos son mayores que los de la bd';

                //Compruebo que si no hay 10 filas, añado el resultado directamente
                if($bd->num_Filas($puntosOk) > 0 && $bd->num_Filas($puntosOk) < 10) {
                    echo '[debug, añado una nueva puntuación]';
                    $bd->insertarDatos(1,1,$puntos);
                } else { //Si hay 10 filas, actualizo el resultado
                    echo '[Debug] puntuaciones llena, actualizo.<br>';

                    print_r($filaPuntosMin);
                    echo "Puntuacion minima recogida: ". $filaPuntosMin["puntuacion"] . " con id: ". $filaPuntosMin["idPartida"];
                    $bd->modificar($puntos, $filaPuntosMin["idPartida"]);
                }

            } else {
                echo 'No entras en el top 10.';
            }
    //}

        

echo '<br>Tus puntos: '.$puntos;

        //Si los puntos son mayor que los de la b.d ó no hay 10 filas, insertamos.
        
        //$bd->insertarDatos(1,1,$puntos);
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