<?php
require_once 'class.conexion.php';

class Usuario extends Conexion {

    function __construct() {
        parent::__construct();
    }

    //CREATE = INSERT
    public function add($nombre, $clave) {
        $clave = password_hash($clave, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios VALUES (0,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ss', $nombre, $clave);
        $stmt->execute();
        $stmt->close();
    }

    //READ = SELECT
    public function getUsuarios() {
        $sql = "SELECT * FROM usuarios ORDER BY idUsuario DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getUsuario($id) {
        $sql = "SELECT * FROM usuarios WHERE idUsuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getUsuarioAcceso($nombre) {
        $sql = "SELECT * FROM usuarios WHERE nombre = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    // UPDATE = UPDATE = EDIT
    public function edit($id, $nombre, $clave) {
        $clave = password_hash($clave, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare('UPDATE usuarios SET nombre = ?, clave = ? WHERE idUsuario = ?');
        $stmt->bind_param('ssi', $nombre, $clave, $id);
        $stmt->execute();
        $stmt->close();
    }

    //DELETE = DELETE
    public function del($id) {
        $sql = "DELETE FROM usuarios WHERE idUsuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>