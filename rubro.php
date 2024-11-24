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
    <title>Alta Rubro</title>

    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="favicon.ico" type="favicon.icon"/>

    
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <main role="main">
        <div class="jumbotron">
            <div class="col-sm-8 mx-auto">
                <h1>Agregar rubro</h1>
                <form action="php/altarubro.php" method="post">
                    <label class="label label-secondary" for="nombre">Nombre del rubro:</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" size="45" required><br>
                    <input class="btn btn-lg btn-success" type="submit" value="Guardar">
                </form>
            </div>
        </div>
    </main>

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