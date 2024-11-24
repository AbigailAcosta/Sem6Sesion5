<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
    $clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';

    include '../class/class.usuarios.php';
    $usuario = new Usuario();
    $result = $usuario->getUsuarioAcceso($nombre);
    $resultado = $result->fetch_array(MYSQLI_ASSOC);

    if ($resultado) {
        $idUsuario = $resultado['idUsuario'];
        $usuario = $resultado['nombre'];
        $hash = $resultado['clave'];

        if (password_verify($clave, $hash)) {
            $_SESSION["idUsuario"] = $idUsuario;
            $_SESSION["usuario"] = $usuario;
            $data = $resultado;
        } else {
            $_SESSION["idUsuario"] = null;
            $_SESSION["usuario"] = null;
            $data = null;
        }
    }

    print json_encode($data);
    exit();
?>