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
    <?php
    include 'header.php';
    ?>

    <title>Listado articulos</title>
    
</head>

<body>
    <?php
    include 'menu.php';
    ?>
    <main role="main">
        <div class="jumbotron">
            <div class="col-sm-12 mx-auto">
                <h2>Listado de articulos</h2>
                <a class="btn btn-primary" href="articulo.php">Nuevo</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DESCRIPCION</th>
                            <th>PRECIO VENTA</th>
                            <th>RUBRO</th>
                            <th colspan="2" class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'class/class.articulos.php';
                        $articulo = new Articulo();
                        $resultado = $articulo->getArticulos();

                        foreach ($resultado as $fila) { ?>
                            <tr>
                                <td><?= $fila['idArticulo'] ?></td>
                                <td><?= $fila['descripcion'] ?></td>
                                <td><?= $fila['precioventa'] ?></td>
                                <td><?= $fila['rubro'] ?></td>
                                <td><a href="earticulo.php?id=<?= $fila['idArticulo'] ?>">editar</a></td>
                                <td><a href="#" onclick="borrar(<?= $fila['idArticulo'] ?>);">borrar</a></td>
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
    <script src="js/articulos.js"></script>
</html>