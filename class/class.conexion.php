<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'config.php';

class Conexion {
    protected $conexion;

    function __construct() {
        $this->conexion = new mysqli(MAQUINA, USUARIO, CLAVE, BASE);
        if ($this->conexion->connect_errno) {
            echo "Fallo en la conexion: ".$this->conexion->connect_errno;
            exit;
        }
        $this->conexion->set_charset(CODIFICACION);
        date_default_timezone_set('America/Asuncion');
    }
}
?>