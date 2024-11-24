<?php
session_start();
$idusuario = $_SESSION['idUsuario'];
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ../');
}

include '../class/class.personas.php';
$personas = new Persona();
$listaproveedores = $personas->getProveedores();
?>

<!DOCTYPE>
<html>
<head> 
    <title>Factura | Compra</title>
    <?php include '../header.php' ?>
</head>
<body>
    <?php include '../menu.php'; ?>
    <br><br>
    <div class="container">
        <div class="card card-success">
            <div class="card-header">
                <h4 class="card-title"><i class="fa fa-edit"></i> Agregando compra </h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" role="form" id="afactura">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo($_SESSION['idUsuario'])?>">
                    <div class="form-group row">
                        <div id="query"></div>
                        <label for="idpersona" class="control-label">Proveedor</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control select" name="idpersona" id="idpersona" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach ($listaproveedores as $fila): ?>
                                        <option id="opcion" value="<?= $fila['idPersona'] ?>"><?= mb_convert_encoding($fila['razonsocial'],'utf8') ?></option>
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
                        <label for="numero" class="col-md-1 control-label">Factura</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="numero" placeholder="999-999-9999999" required>
                        </div>
                        <label for="fecha" class="control-label">Fecha</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="fecha" required>
                        </div>
                        <label for="idcondicion" class="control-label">Estado</label>
                        <div class="col-md-3">
                            <select class='form-control' name="estado" id="estado" value="1" disabled>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-11">
                        <div class="float-none">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#agregarConcepto">
                                <span class="fa fa-search"></span> Añadir producto
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-print"></span> Generar planilla de compra
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

    <script src="../js/afcompra.js"></script>
    <script type="text/javascript">
        $("#idpersona").select2({
            placeholder: "Seleccione proveedor",
            allowClear: true
        });

        $('#agregarproveedor').on('click', function(){
            var page = '../personas.php?add=true';
            window.location.href = page;
        });

        $("#idpersona").change(function(){
            var idpersona = $('#idpersona').val();
            $.ajax({
                type: "POST",
                url: 'buscarproveedor.php',
                data: 'idpersona=' + idpersona,
                beforeSend: function () {
                    $('#query').html("\
                    <center>\
                        <label>Cargando...</label>\
                    </center>");
                },
                success: function(res) {
                    $('#query').html(res);
                }
            });
        });
    </script>
</body>
</html>
