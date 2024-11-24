<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../class/class.articulos.php';
$articulo = new Articulo();

if (isset($_POST)) {
    $descripcion = $_POST['descripcion'];
    $preciocompra = $_POST['preciocompra'];
    $precioventa = $_POST['precioventa'];
    $idrubro = $_POST['idrubro'];
    $articulo->add($descripcion, $preciocompra, $precioventa, $idrubro);
} else {
    echo '<script>alert("Error, no se guardó registro!");</script>';
}

header('location: ../listaarticulos.php');
?>
