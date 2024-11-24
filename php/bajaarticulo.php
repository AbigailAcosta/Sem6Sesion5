<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../class/class.articulos.php';
$articulo = new Articulo();

if (isset($_REQUEST)) {
    $id = $_REQUEST['id'];
    $articulo->del($id);
} else {
    echo '<script>alert("Error, no se borró registro!");</script>';
}

// header('location: ../listaarticulos.php');
?>
