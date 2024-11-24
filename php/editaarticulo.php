<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../class/class.articulos.php';
$articulo = new Articulo();

if (isset($_POST)) {
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    $preciocompra = $_POST['preciocompra'];
    $precioventa = $_POST['precioventa'];
    $idrubro = $_POST['idrubro'];
    $articulo->edit($id, $descripcion, $preciocompra, $precioventa, $idrubro);
} else {
    echo '<script>alert("Error, no se actualizó registro!");</script>';
}

header('location: ../listaarticulos.php');
?>
