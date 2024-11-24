<?php
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
    <title>.: Compras :.</title>
</head>

<body>
    <?php include 'menu.php'; ?>
    <br><br>

    <div class="container">
        <div class="card card-info">
            <div class="card-heading">
                <div class="btn-group float-right">
                    <a href="compras/agregarfactura.php" class="btn btn-success">
                        <span class="fa fa-plus"></span> Agregar Factura
                    </a>
                </div>
                <h3>Facturas de compras</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" role="form" id="formFactura">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-2">Razón Social</label>
                        <div class="col-md-5">
                            <input class="form-control" type="text" name="textobuscar" id="textobuscar" placeholder="Teclee razón social a buscar">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="load(1);">
                                <span class="fa fa-search"></span> Buscar
                            </button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                <div id="resultados"></div>
                <div id="salidas"></div>
            </div>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>
<script src="http://localhost/semana6/tallerpoophp/js/fcompras.js"></script>

</html>