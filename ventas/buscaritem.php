<?php
session_start();
$usuario = $_SESSION["usuario"];

if ($usuario == null) {
    header('location: ../');
}

include '../php/pagination.php';
include '../class/class.articulos.php';

$articulos = new Articulo();

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
    $aColumns = array('descripcion');
    $sTable = 'articulos';
    $sWhere = ' WHERE idArticulo > 0 ';

    if (isset($_GET['q']) && $_GET['q'] != null) {
        $q = $_GET['q'];
        $sWhere .= " AND descripcion LIKE '%" . $q . "%' ";
    }

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5;
    $adjacents = 2;
    $offset = ($page - 1) * $per_page;

    $sql = "SELECT count(*) AS numrows FROM $sTable $sWhere";
    $count_query = $articulos->getArticulosSQL($sql);
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = 'agregarfactura.php';

    $sFields = "`articulos`.`idArticulo`, `articulos`.`descripcion`, 
                ROUND(`articulos`.`precioventa`, 0) AS precioventa";
    $sql = "SELECT $sFields FROM $sTable $sWhere LIMIT $offset, $per_page";
    $query = $articulos->getArticulosSQL($sql);

    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr class="warning">
                    <th>Código</th>
                    <th>Descripción</th>
                    <th><span class="float-right">Cant.</span></th>
                    <th><span class="float-right">Precio Venta</span></th>
                    <th class="text-center" style="width: 36px;">Agregar</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $idConcepto = $row['idArticulo'];
                    $descripcion = $row['descripcion'];
                    $precioUnitario = $row['precioventa'];
                    ?>
                    <tr>
                        <td><?php echo $idConcepto; ?></td>
                        <td><?php echo $descripcion; ?></td>
                        <input type="hidden" id="concepto_<?php echo $idConcepto; ?>" value="<?php echo $descripcion; ?>">
                        <td class='col-xs-1'>
                            <div class="float-right">
                                <input type="text" class="form-control" style="text-align: right" 
                                       id="cantidad_<?php echo $idConcepto; ?>" value="1">
                            </div>
                        </td>
                        <td class='col-xs-2'>
                            <div class="float-right">
                                <input type="text" class="form-control" style="text-align: right" 
                                       id="precio_<?php echo $idConcepto; ?>" value="<?php echo $precioUnitario; ?>">
                            </div>
                        </td>
                        <td class='text-center'>
                            <a class='btn btn-info' href="#" onclick="agregar('<?php echo $idConcepto; ?>')">
                                <i class="fa fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5">
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
