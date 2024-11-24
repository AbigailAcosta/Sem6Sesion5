<?php
require_once 'class.conexion.php';

class Articulo extends Conexion {
    function __construct() {
        parent::__construct();
    }

    public function getArticulosSQL($sql) {
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    // CREATE = INSERT
    public function add($descripcion, $preciocompra, $precioventa, $idrubro) {
        $sql = "INSERT INTO articulos VALUES (0,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('siii', $descripcion, $preciocompra, $precioventa, $idrubro);
        $stmt->execute();
        $stmt->close();
    }

    // READ = SELECT
    public function getArticulos() {
        $sql = "SELECT a.idArticulo, a.descripcion, a.preciocompra, a.precioventa, r.nombre AS rubro, a.idRubro 
                FROM articulos a, rubros r 
                WHERE a.idRubro = r.idRubro 
                ORDER BY a.idArticulo DESC";
        $stmt = $this->conexion->prepare($sql); 
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    public function getArticulo($id) {
        $sql = "SELECT a.idArticulo, a.descripcion, a.preciocompra, a.precioventa, r.nombre AS rubro, a.idRubro 
                FROM articulos a, rubros r 
                WHERE a.idRubro = r.idRubro AND a.idArticulo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }

    // UPDATE = UPDATE = EDIT
    public function edit($id, $descripcion, $preciocompra, $precioventa, $idrubro) {
        $stmt = $this->conexion->prepare('UPDATE articulos SET descripcion = ?, preciocompra = ?, precioventa = ?, idRubro = ? WHERE idArticulo = ?');
        $stmt->bind_param('siiii', $descripcion, $preciocompra, $precioventa, $idrubro, $id);
        $stmt->execute();
        $stmt->close();
    }

    // DELETE = DELETE
    public function del($id) {
        $sql = "DELETE FROM articulos WHERE idArticulo = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
