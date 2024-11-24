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
    <title>Error 404</title>

    <!-- BOOTSTRAP 4 -->
    <?php
        include 'header.php';
    ?>
</head>

<body>
    <?php
        include 'menu.php';
    ?>
    <main role="main">
        <div class="jumbotron">
            <div class="col-sm-8 mx-auto">
                <h3>No existe programa.!</h3>
                <a href="dashboard.php" class="btn btn-warning">Volver</a>
            </div>
        </div>
    </main>
</body>
    <?php
        include 'footer.php';
    ?>
</html>