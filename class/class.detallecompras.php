<?php

class DetalleCompra {
    function __construct() {
        // constructor
    }

    public function getDetalles($sesion) {
        return json_decode(file_get_contents("../compras/tmpdetallescompras$sesion.json"), true);
    }

    public function getDetalleById($id, $sesion) {
        $detalles = $this->getDetalles($sesion);
        foreach ($detalles as $detalle) {
            if ($detalle['id'] == $id) {
                return $detalle;
            }
        }
        return null;
    }

    public function createDetalleExist($data, $sesion) {
        $detalles = $this->getDetalles($sesion);
        $detalles[] = $data;
        $this->putJson($detalles, $sesion);
    }

    public function createDetalleNotExist($data, $sesion) {
        $detalles[] = $data;
        $this->putJson($detalles, $sesion);
    }

    public function deleteDetalle($id, $sesion) {
        $detalles = $this->getDetalles($sesion);
        foreach ($detalles as $i => $detalle) {
            if ($detalle['idTmpDetalle'] == $id) {
                array_splice($detalles, $i, 1);
            }
        }
        $this->putJson($detalles, $sesion);
    }

    public function deleteAllDetalles($sesion) {
        $detalles = $this->getDetalles($sesion);
        foreach ($detalles as $i => $detalle) {
            array_splice($detalles, $i, 1);
        }
        $this->putJson($detalles, $sesion);
    }

    public function putJson($detalles, $sesion) {
        file_put_contents("../compras/tmpdetallescompras$sesion.json", json_encode($detalles, JSON_PRETTY_PRINT));
    }
}
?>
