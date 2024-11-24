<?php
require_once 'class.conexion.php';

class persona extends Conexion {

    function __construct() {
        parent::__construct();
    }

    //CREATE = INSERT
    public function add($descripcion, $precioventa, $idrubro) {
        $sql = "INSERT INTO personas VALUES (0,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sii', $descripcion, $precioventa, $idrubro);
        $stmt->execute();
        $stmt->close();
    }

    //READ = SELECT
    public function getPersonas() {
        $sql = "SELECT * FROM personas ORDER BY idPersona DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getProveedores() {
        $sql = "SELECT * FROM personas WHERE tipo=2 OR tipo=3 ORDER BY idPersona DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getClientes() {
        $sql = "SELECT * FROM personas WHERE tipo=1 OR tipo=3 ORDER BY idPersona DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getPersona($id) {
        $sql = "SELECT * FROM personas WHERE idPersona = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    // UPDATE = UPDATE = EDIT
    public function edit($id, $descripcion, $precioventa, $idrubro) {
        $stmt = $this->conexion->prepare('UPDATE personas SET descripcion = ?, precioventa = ?, idRubro = ? WHERE idPersona = ?');
        $stmt->bind_param('siii', $descripcion, $precioventa, $idrubro, $id);
        $stmt->execute();
        $stmt->close();
    }

    //DELETE=DELETE
    public function del($id) {
        $sql = "DELETE FROM personas WHERE idPersona = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>