<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'class.conexion.php';

class Rubro extends Conexion {

    function __construct() {
        parent::__construct();
    }

    //CREATE = INSERT
    public function add($nombre) {
        $sql = "INSERT INTO rubros VALUES (0,?,10)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $stmt->close();
    }

    //READ = SELECT
    public function getRubros() {
        $sql = "SELECT * FROM rubros ORDER BY idRubro DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getRubro($id) {
        $sql = "SELECT * FROM rubros WHERE idRubro = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    // UPDATE = UPDATE = EDIT
    public function edit($id, $nombre) {
        $stmt = $this->conexion->prepare('UPDATE rubros SET nombre = ? WHERE idRubro = ?');
        $stmt->bind_param('si', $nombre, $id);
        $stmt->execute();
        $stmt->close();
    }

    //DELETE=DELETE
    public function del($id) {
        $sql = "DELETE FROM rubros WHERE idRubro = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>