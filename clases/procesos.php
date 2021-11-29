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
         * Hace un select de un usuario especifico, devuelve una fila con el campo de contraseña.
        */
        function seleccionar($customSQL=null, $where = null) {

            //Si no se envia ningun parametro devuelve todo (select *)
            if($where == null)
                $sql = "SELECT * FROM partidas";
            else {//Si no devuelve con el where especificado. 
                $sql = "SELECT $customSQL FROM partidas ".$where;
                //echo 'ee: '.$sql;
            }

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