<?php
session_start();
$idusuario = $_SESSION['idUsuario'];
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ../');
}

include '../class/class.personas.php';
$personas = new Persona();
$listaclientes = $personas->getClientes();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Factura | Venta</title>
    <?php include '../header.php' ?>
</head>
<body>
    <?php include '../menu.php'; ?>
    <br><br>
    <div class="container">
        <div class="card card-success">
            <div class="card-header">
                <h4 class="card-title"><i class="fa fa-edit"></i> Agregando venta</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" role="form" id="afactura">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo($_SESSION['idUsuario']) ?>">

                    <div class="form-group row">
                        <div id="query"></div>
                        <label for="idpersona" class="control-label">Cliente</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control select" name="idpersona" id="idpersona" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($listaclientes as $fila): ?>
                                        <option id="opcion" value="<?= $fila['idPersona'] ?>">
                                            <?= mb_convert_encoding($fila['razonsocial'], 'utf8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <label for="telefono" class="control-label">Teléfono</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="telefono" readonly>
                        </div>

                        <label for="cedula" class="control-label">RUC</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cedula" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="numero" class="control-label">Factura</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="numero" placeholder="autogenerado" readonly>
                        </div>

                        <label for="fecha" class="control-label">Fecha</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="fecha" required>
                        </div>

                        <label for="condicion" class="control-label">Condicion</label>
                        <div class="col-md-3">
                            <select class='form-control' name="condicion" id="condicion" value="1">
                                <option value="1">Contado</option>
                                <option value="2">Crédito</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-11">
                        <div class="float-none">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarConcepto">
                                <span class="fa fa-search"></span> Añadir producto
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-print"></span> Imprimir factura
                            </button>
                        </div>
                    </div>
                </form>

                <div id="resultados" class='col-md-12' style="margin-top:10px"></div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="col-md-12"></div>
        </div>
    </div>

    <?php include 'buscarfacturaitem.php' ?>
    <?php include '../footer.php' ?>

    <script src="../js/afventa.js"></script>
    <script type="text/javascript">
        $("#idpersona").select2({
            placeholder: "Seleccione cliente",
            allowClear: true
        });

        $("#idpersona").change(function () {
            var idpersona = $('#idpersona').val();
            $.ajax({
                type: "POST",
                url: 'buscarcliente.php',
                data: 'idpersona=' + idpersona,
                beforeSend: function () {
                    $('#query').html("<center><label>Cargando...</label><center>");
                },
                success: function (res) {
                    $('#query').html(res);
                }
            });
        });
    </script>
</body>
</html>
