<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $id = $_REQUEST['id'];
    $nombre = $_REQUEST['nombre'];

    include '../class/class.rubros.php';
    $rubro = new Rubro();

    if (isset($_POST)) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $rubro->edit($id, $nombre);
    } else {
        echo '<script>alert("Error, no se actualizó registro!");</script>';
    }
    header('location: ../listarubros.php');
?>