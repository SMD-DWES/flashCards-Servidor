<?php
    /**
     * @author Sergio Matamoros Delgado
    */
    require_once "operacionesBd.php";
    class Procesos extends OperacionesBd {
        //Vars
        private $mysql = null;

        function __construct()
        {
            $this->mysql = $this->inicioBd();
        }

        /**
         * Selecciona lo especificado por el sistema.
         * @param customSQL Permite introducir nombres de columna
         * @param where Parametro que permite introducir un WHERE statement.
        */
        function seleccionar($customSQL) {

            //SQL custom especificado en param
            $sql = $customSQL;

            $consulta = $this->consultar($sql);
            if($consulta) 
                return $consulta;
            else
                return $this->mysql->error;

        }

        /**
         * Inserta los datos de una nueva puntuación
        */
        function insertarDatos($idUsuario,$idMinijuego,$puntuacion) {

            $sql = "INSERT INTO partidas(idUsuario, idMinijuego, puntuacion) VALUES ($idUsuario,$idMinijuego,$puntuacion)";

            $consulta = $this->consultar($sql);
            if($consulta)
                return 'Datos añadidos correctamente';
            else
                return $this->mysql->errno;
        }


        /**
         * Modifica una puntuacion
        */
        function modificar($puntuacion, $id) {
            $sql = "UPDATE partidas SET puntuacion=$puntuacion WHERE idPartida=$id";

            $consulta = $this->consultar($sql);
            if($consulta)
                return 'Datos modificados correctamente';
            else
                return $this->mysql->errno;

        }
    }
?>