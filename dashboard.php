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
    <meta charset="UTF-8" />
    <title>CRUD PHP POO</title>

    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" href="favicon.ico" type="favicon.icon"/>
</head>

<body>
    <?php
        include 'menu.php';
    ?>
</body>
    <?php
        include 'footer.php';
    ?>

</html>