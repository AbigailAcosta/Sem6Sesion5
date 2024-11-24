<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
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
    ?>

    <main role="main">
        <div class="jumbotron">
            <div class="col-sm-8 mx-auto">
                <h1>Agregar articulo</h1>
                <form action="php/altaarticulo.php" method="post">
                    <label class="label label-secondary" for="descripcion">Descripcion:</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" size="45" required><br>
                    <label class="label label-secondary" for="preciocompra">Precio de compra:</label>
                    <input class="form-control" type="text" name="preciocompra" id="preciocompra" size="11" required><br>
                    <label class="label label-secondary" for="precioventa">Precio de venta:</label>
                    <input class="form-control" type="text" name="precioventa" id="precioventa" size="11" required><br>
                    <label class="label label-secondary" for="idrubro">Rubro:</label>
                    <select class="form-control" name="idrubro" id="idrubro">
                        <option value="0">SELECCIONE</option>
                        <?php
                        include 'class/class.rubros.php';
                        $rubro = new Rubro();
                        $resultado = $rubro->getRubros();

                        foreach ($resultado as $fila) { ?>
                            <option value="<?= $fila['idRubro'] ?>"><?= $fila['nombre'] ?></option>
                        <?php 
                            } 
                        ?>
                    </select><br>
                    <input class="btn btn-lg btn-success" type="submit" value="Guardar">
                </form>
            </div>
        </div>
    </main>

</body>
    <?php 
        include 'footer.php';
    ?>
    <script src="js/articulos.js"></script>
    <script>
        document.getElementById("descripcion").addEventListener("keypress", forceKeyPressUppercase, false);
    </script>
</html>