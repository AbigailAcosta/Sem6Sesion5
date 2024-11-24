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
    <title>Listado Rubros</title>

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
                <h2>Listado de rubros</h2>
                <a class="btn btn-primary" href="rubro.php">Nuevo</a>
                <a class="btn btn-warning" target="_blank" href="pdf/listarubros.php">PDF Simple</a>
                <a class="btn btn-danger" target="_blank" href="pdf/listarubros2.php">PDF Formateado</a>
                <a class="btn btn-info" target="_blank" href="xls/listarubros_html.php">XLSX Simple</a>
                <a class="btn btn-success" href="xls/listarubros2_xlsx.php">XLSX Formateado</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th colspan="2" class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'class/class.rubros.php';
                        $rubro = new Rubro();
                        $resultado = $rubro->getRubros();

                        foreach ($resultado as $fila) { ?>
                            <tr>
                                <td><?=$fila['idRubro'] ?></td>
                                <td><?=$fila['nombre'] ?></td>
                                <td><a href="erubro.php?id=<?php echo $fila['idRubro'] ?>">editar</a></td>
                                <td><a href="#" onclick="borrar(<?=$fila['idRubro']?>);">borrar</a></td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <?php
        include 'footer.php';
    ?>
    <script src="js/rubros.js"></script>
</html>