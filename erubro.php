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
    <title>Edición Rubro</title>

    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">

</head>

<body>
    <?php
    include 'menu.php';

    $id = $_REQUEST['id'];

    include 'class/class.rubros.php';
    $rubro = new Rubro();
    $resultado = $rubro->getRubro($id);

    foreach ($resultado as $fila) { ?>
        <main role="main">
            <div class="jumbotron">
                <div class="col-sm-8 mx-auto">
                    <h1>Modificación de rubro</h1>
                    <form action="php/editarubro.php" method="post">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <label class="label label-secondary" for="nombre">Nombre del rubro:</label>
                        <input class="form-control" type="text" name="nombre" id="nombre" size="45" value="<?php echo $fila['nombre'] ?>" required><br>
                        <input class="btn btn-lg btn-success" type="submit" value="Actualizar">
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
    <script src="js/rubros.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById("nombre").addEventListener("keypress", forceKeyPressUppercase, false);
        });
    </script>
</html>