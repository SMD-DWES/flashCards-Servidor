<?php
    /*
        @author: Sergio Matamoros Delgado <smatamorosdelgado.guadalupe@alumnado.fundacionloyola.net>
        @license: GPL v3 2021
        @description: BackEnd del minijuego de flashcards. 
        Se encarga de insertar los puntos en el top 10 puntuaciones de la B.D.
    */
    
    require __DIR__."/clases/procesos.php";
    require_once __DIR__ . "/estructura/maquetacion.php";

    //Versión 1 se elige un minijuego (desplegable)
    //Versión 2 se elige varios minijuegos en checkboxes

    session_start();
    //Comprobamos que tenga la sesión iniciada
    if(!isset($_SESSION["id"])) { header("Location: login.php"); }

    //Carga el HTML
    echo '<html>';
    head("Puntos");
    nav();
    main("puntuacion");
    echo '</html>';
    
    /**
     * Función que se ejecutará la primera vez que el usuario entre en la página
     * para las preferencias de los minijuegos.
     */
    function firstLogin() {

        $db = new Procesos();

        //Comprobar si es la primera vez que entra
        if(isset($_SESSION["firstLogin"])) {

            //Select de minijuegos
            $selMinijuegos = $db->seleccionar("SELECT * FROM minijuegos");
            

            //Creación de los desplegables
            echo 'Bienvenido por primera vez!<br>';

            //Creación de una variable de "cache" para poder utilizar 2 veces el resultado
            //sin volver a tener que hacer la consulta 2 veces.
            $cache = array();

            //Creación del select con los valores recogidos de la B.D
            echo 
            "
            <form action='#' method='POST'>
                <select name='seleccionMG[]'>
                    <option name='minijuego' value='0'>Selecciona un minijuego</option>
            ";

            while($fila = $db->selectArray($selMinijuegos, MYSQLI_ASSOC)) {

                //Almacenamos la fila en otra array para poder recorrerla sin tener que empezar de 0 otra vez.
                $cache[] = $fila;

                echo "<option name='minijuego' value='$fila[idMinijuego]'>$fila[nombre]</option>";
                
            }
            echo "
                </select>
                <input type='submit' value='Enviar' name='sendPreferencias'>
            </form>
            ";

            echo '<br><br>';

            //Creación de los checkboxes

            echo "
            <form action='#' method='POST'>
            ";

            // *-- Explicación: --* //
            //Utilizamos el cache para obtener los valores sin volver a hacer un query.
            //Esta es la opción con mejor rendimiento, y de hecho si se hiciera un selectArray como el
            //de arriba no funcionaria, ya que los datos del IO obtenidos del query seran tratados como STREAM,
            //por lo que no se podrá volver a empezar de 0 sin volver a ejecutar el query.
            //Si devolviera muchas filas (como 1000 por ejemplo), saldría más rentable volver a ejecutar
            //el query.
            foreach ($cache as $valor) {
                echo 
                "
                    <label for='$valor[idMinijuego]'> $valor[nombre]</label>
                    <input type='checkbox' id='$valor[idMinijuego]' name='minijuegoChx' value='$valor[nombre]' />
                ";
            }
            echo "
                <input type='submit' value='Enviar' name='sendPreferencias'>
            </form>
            ";
        }
    }

    if(isset($_POST["sendPreferencias"])) {
        //Una vez rellenado no te volverá a salir las preferencias.
        //$_SESSION["firstLogin"] = false;

        //Select
        if(!empty($_POST["seleccionMG"])) {

            foreach ($_POST["seleccionMG"] as $valor) {
                echo $valor . '<br>';
            }
        } else {
            echo 'Error, seleccione un valor de la lista.';
        }

        if(isset($_POST["minijuegoChx"])) {
            echo 'Has seleccionado: '. $_POST["minijuegoChx"];
        }



        print_r($_POST["sendPreferencias"]);
    }


    //FORMULARIO QUE PIDA LOS PUNTOS A INSERTAR
    if(isset($_POST["enviar"])) {

        $puntos = $_POST["iPuntos"];

        $bd = new Procesos();

        //Seleccionamos el top 10 (este se podría hacer con un * no es necesario el top.)
        $puntosOk = $bd->seleccionar("order by puntuacion desc limit 1");

        //Seleccionamos el top 10 de partidas, pero con la puntuación más baja
        $minPuntos = $bd->seleccionar("idPartida, puntuacion","WHERE puntuacion = (SELECT MIN(puntuacion) FROM partidas)");

        $filaPuntosMin = $bd->selectArray($minPuntos,MYSQLI_ASSOC);


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
