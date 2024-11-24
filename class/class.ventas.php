<?php
require_once '../class/class.conexion.php';

class Venta extends Conexion {
    function __construct() {
        parent::__construct();
    }
 
    public function getVenta($numero) {
        $sql = "select * from ventas where numero = '" . $numero . "'";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function getVentas() {
        $sql = 'select * from ventas order by numero desc';
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    // esta seccion se ejecuta sql en forma interactiva
    public function getVentaSQL($sql) {
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function addVenta($fecha, $condicion, $anulado, $idusuario, $idcliente)
    {
        $sql = "INSERT INTO ventas VALUES (0, CURDATE(), ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('iiii', $condicion, $anulado, $idusuario, $idcliente);
        $stmt->execute();
        $ultimo = $stmt->insert_id;
        $stmt->close();
        return $ultimo;
    }

    public function addDetalleVenta($numero, $idconcepto, $unitario, $cantidad, $impuesto)
    {
        $sql = "INSERT INTO detalleventas VALUES (?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('iiiii', $numero, $idconcepto, $unitario, $cantidad, $impuesto);
        $stmt->execute();
        $stmt->close();
    }
}
?>
