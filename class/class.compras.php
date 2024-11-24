<?php
require_once '../class/class.conexion.php';

class Compra extends Conexion {
    function __construct() {
        parent::__construct();
    }

    public function getFactura($numero_compra) {
        $sql = "select * from compras where numero_compra = '".$numero_compra."'";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function getFacturas() {
        $sql = 'select * from compras order by numero_compra desc';
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function getFacturaSQL($sql) {
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function addFactura($numero, $fecha, $idproveedor, $estado, $idusuario) {
        $sql = "INSERT INTO compras VALUES (?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('ssiii', $numero, $fecha, $estado, $idusuario, $idproveedor);
        $stmt->execute();
        $stmt->close();
    }

    public function addDetalleFactura($numero, $idarticulo, $unitario, $cantidad, $impuesto) {
        $sql = "INSERT INTO detallecompras VALUES (?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('siiii', $numero, $idarticulo, $unitario, $cantidad, $impuesto);
        $stmt->execute();
        $stmt->close();
    }

}
?>