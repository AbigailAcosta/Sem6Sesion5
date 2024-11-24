<?php
session_start();
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ../');
}

require_once('../class/class.ventas.php');
$ventas = new Venta();

$action = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] != null) {
    $action = $_REQUEST['action'];
}

if (isset($_REQUEST['numero_venta'])) {
    $numero_venta = $_REQUEST['numero_venta'];
    $sql = "UPDATE ventas SET anulado=1 WHERE numero = '$numero_venta'";
    $sqlanula = $ventas->getVentaSQL($sql);

    if ($sqlanula) {
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Aviso!</strong> Venta anulada exitosamente!
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Error!</strong> No se puede anular esta Venta
        </div>
        <?php
    }
}

if ($action == 'ajax') {
    $sTable = 'vventas';
    $sWhere = "WHERE vventas.numero_venta > 0";

    if (isset($_REQUEST['q']) && $_REQUEST['q'] != null) {
        $q = $_REQUEST['q'];
        $sWhere .= " AND vventas.razon_social LIKE '%" . $q . "%'";
    }

    $sWhere = " ORDER BY vventas.numero_venta DESC";

    include '../php/pagination.php';

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5;
    $adjacents = 3;
    $offset = ($page - 1) * $per_page;

    $sql = 'SELECT count(*) as numrows FROM ' . $sTable . $sWhere;
    $count_query = $ventas->getVentaSQL($sql);
    $row = $count_query->fetch_array();
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = '../listaventas.php';

    $sql = 'SELECT * FROM ' . $sTable . $sWhere . ' LIMIT ' . $offset . ',' . $per_page;
    $query = $ventas->getVentaSQL($sql);

    if ($numrows > 0) {
        ?>
        <br>
        <div class="table-responsive">
            <table class="table">
                <tr class="info">
                    <th>Factura</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th class='text-right'>Condición</th>
                    <th class='text-right'>Usuario</th>
                    <th class='text-right'>Anulada</th>
                    <th class='text-right'>Acción</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $numero_venta = $row['numero_venta'];
                    $fecha = date("d/m/Y", strtotime($row['fecha_venta']));
                    $razon_social = $row['razon_social'];
                    $condicion = $row['condicion'];
                    $anulado = $row['anulado'];
                    $agente = $row['nombre_usuario'];

                    if ($anulado == 1) {
                        $text_anulado = "SI";
                        $label_class = 'badge-danger';
                    } else {
                        $text_anulado = "NO";
                        $label_class = 'badge-secondary';
                    }
                    ?>
                    <tr>
                        <td><?php echo $numero_venta; ?></td>
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $razon_social; ?></td>
                        <td class='text-right'><?php echo $condicion; ?></td>
                        <td class='text-right'><?php echo $agente; ?></td>
                        <td class='text-right'>
                            <span class="badge <?php echo $label_class; ?>"><?php echo $text_anulado; ?></span>
                        </td>
                        <td class="text-right">
                            <a href="#" class='btn btn-default' title='Anular factura' onclick="borrar('<?php echo $numero_venta; ?>')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="7">
                        <span class="float-right">
                            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }
}
?>
