<?php
session_start();
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ../');
}

require_once('../class/class.compras.php');
$compras = new Compra();

$action = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] != null) {
    $action = $_REQUEST['action'];
}

if (isset($_REQUEST['numero_compra'])) {
    $numero_compra = $_REQUEST['numero_compra'];
    $sql = "DELETE FROM compras WHERE numero = '$numero_compra'";
    $sqlanula = $compras->getFacturaSQL($sql);
    if ($sqlanula) { ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> Factura eliminada exitosamente!
        </div>
    <?php
    } else { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> No se puede Borrar esta factura
        </div>
    <?php
    }
}

if ($action == 'ajax') {
    $sTable = ' vcompras ';
    $sWhere = " WHERE vcompras.numero_compra > '0' ";

    if (isset($_REQUEST['q']) && $_REQUEST['q'] != null) {
        $q = $_REQUEST['q'];
        $sWhere .= " AND vcompras.razon_social LIKE '%".$q."%' ";
    }

    $sWhere .= " ORDER BY vcompras.numero_compra DESC";

    include '../php/pagination.php';

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5;
    $adjacents = 3;
    $offset = ($page - 1) * $per_page;
    $sql = 'select count(*) as numrows from ' . $sTable . $sWhere;
    //echo $sql;
    $count_query = $compras->getFacturaSQL($sql);
    $row = $count_query->fetch_array();
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = '../listacompras.php';

    $sql = 'select * from ' . $sTable . $sWhere . ' LIMIT ' . $offset . ',' . $per_page;
    $query = $compras->getFacturaSQL($sql);
    //echo $sql;
    if ($numrows > 0) { ?>
        <br>
        <div class="table-responsive">
            <table class="table">
                <tr class="info">
                    <th>Factura</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th class='text-right'>Estado</th>
                    <th class='text-right'>Usuario</th>
                    <th class='text-right'>Acción</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $numero_compra = $row['numero_compra'];
                    $fecha = date("d/m/Y", strtotime($row['fecha_compra']));
                    $razon_social = $row['razon_social'];
                    $estado = $row['estado'];
                    $agente = $row['nombre_usuario'];
                ?>
                    <tr>
                        <td><?php echo $numero_compra; ?></td>
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $razon_social; ?></td>
                        <td class='text-right'><?php echo $estado; ?></td>
                        <td class='text-right'><?php echo $agente; ?></td>
                        <td class="text-right">
                            <a href="#" class='btn btn-default' title='Borrar factura' onclick="borrar('<?php echo $numero_compra; ?>')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="7"><span class="float-right"><?php
                        echo paginate($reload, $page, $total_pages, $adjacents);
                    ?></span></td>
                </tr>
            </table>
        </div>
    <?php
    }
}

?>