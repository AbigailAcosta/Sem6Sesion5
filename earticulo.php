<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ./');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta articulo</title>

    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">

</head>

<body>
    <?php

    include 'menu.php';
    include 'class/class.articulos.php';

    $articulo = new Articulo();
    $id = $_REQUEST['id'];
    $resultado = $articulo->getArticulo($id);

    foreach ($resultado as $fila) { ?>
        <main role="main">
            <div class="jumbotron">
                <div class="col-sm-8 mx-auto">
                    <h1>Editar articulo</h1>
                    <form action="php/editaarticulo.php" method="post">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <label class="label label-secondary" for="descripcion">Descripcion:</label>
                        <input class="form-control" type="text" name="descripcion" id="descripcion" size="45" value="<?= $fila['descripcion'] ?>" required><br>
                        <label class="label label-secondary" for="precioventa">Precio de venta:</label>
                        <input class="form-control" type="text" name="precioventa" id="precioventa" size="45" value="<?= $fila['precioventa'] ?>" required><br>
                        <label class="label label-secondary" for="idrubro">Rubro:</label>
                        <select class="form-control" name="idrubro" id="idrubro" value="<?= $fila['idrubro'] ?>">
                            <option value="0">SELECCIONE</option>
                            <?php
                                error_reporting(E_ALL);
                                ini_set('display_errors', 1);

                                include 'class/class.rubros.php';
                                $rubro = new Rubro();
                                $resultador = $rubro->getRubros();

                                foreach ($resultador as $filar) { ?>
                                    <option value="<?= $filar['idRubro'] ?>" <?php if ($filar['idRubro'] == $fila['idRubro']) echo 'selected' ?>>
                                        <?= $filar['nombre'] ?></option>
                                <?php 
                                    } 
                                ?>
                        </select><br>
                        <input class="btn btn-lg btn-success" type="submit" value="Guardar">
                    
                    </form>
                </div>
            </div>
    </main>
    <?php 
        } 
    ?>
</body>
    <?php 
        include 'footer.php'; 
    ?>

    <script src="js/articulos.js"></script>
    <script>
        document.getElementById("descripcion").addEventListener("keypress", forceKeyPressUppercase, false);
    </script>
</html>