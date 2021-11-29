<?php
    /**
     * @author Sergio Matamoros Delgado
    */
    require_once "config_bd.php";

    class OperacionesBd {

        //Vars
        private $mysql = null;

        /**
         * Inicia la BBDD
        */
        function inicioBd() {
            return $this->mysql = new mysqli(HOSTNAME,USERNAME,PASSWORD,DATABASE);
        }

        /**
         * Cierra la conexión con la BBDD
        */
        function cerrarBd() {
            $this->mysql->close();
        }


        /*
            Hace un query de la consulta pedida
        */
        function consultar($consulta) {
            return $this->mysql->query($consulta);
        }

        /**
         * Devuelve el numero de filas
         */
        function num_Filas($result) {
            return $result->num_rows;
        }



        /**
         * Devuelve la fila usando un fetchArray
         */
        function selectArray($result, $tipo) {
            return $result->fetch_array($tipo);
        }
    }
?>