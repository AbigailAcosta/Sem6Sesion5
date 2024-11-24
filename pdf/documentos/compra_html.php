<style type="text/css">
    table { vertical-align: top; }
    tr { vertical-align: top; }
    td { vertical-align: top; }
    .midnight-blue {
        background: #2c3e50;
        padding: 4px 4px 4px;
        color: white;
        font-weight: bold;
        font-size: 12px;
    }
    .silver {
        background: white;
        padding: 3px 4px 3px;
    }
    .clouds {
        background: #ecf0f1;
        padding: 3px 4px 3px;
    }
    .border-top {
        border-top: solid 1px #bdc3c7;
    }
    .border-left {
        border-left: solid 1px #bdc3c7;
    }
    .border-right {
        border-right: solid 1px #bdc3c7;
    }
    .border-bottom {
        border-bottom: solid 1px #bdc3c7;
    }
    table.page_footer {
        width: 100%;
        border: none;
        background-color: white;
        padding: 2mm;
        border-collapse: collapse;
        border: none;
    }
</style>

<!-- <meta http-equiv="Content-type" content="text/html; charset=utf-8" /> -->

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial">
    <table cellspacing="0" style="width: 100%;">
        <tr>
            <!-- <td style="width: 25%; color: #444444;">
            <img style="width: 20%;" src="../../images/bg.png" alt="Logo"><br>
            </td> -->
            <td style="width: 50%; color: #34495e; font-size: 12px; text-align: center">
                <span style="color: #34495e; font-size: 14px; font-weight: bold">
                    <?php echo NOMBRE_EMPRESA; ?>
                </span><br>
                <?php echo DIRECCION_EMPRESA; ?><br>
                Teléfono: <?php echo TELEFONO_EMPRESA; ?><br>
                Email: <?php echo EMAIL_EMPRESA; ?>
            </td>
            <td style="width: 25%; text-align: right">
                PLANILLA DE COMPRA <?php echo $numero_factura; ?>
            </td>
        </tr>
    </table>
    <br>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <td style="width: 100%;" class='midnight-blue'>RAZON SOCIAL</td>
        </tr>
        <tr>
            <td style="width: 50%;">
                <?php
                $sql = "SELECT * FROM personas WHERE idPersona='$idproveedor'";
                $sql_razon = $factura->getFacturaSQL($sql);
                $rw_razon = mysqli_fetch_array($sql_razon);
                $cadenaproveedor = "";
                $cadenaproveedor .= "
                <pre><b>RAZON SOCIAL: </b>" . $rw_razon['razonsocial'] . 
                "<br><b>CI o RUC: </b>" . $rw_razon['ciruc'] . 
                "<br><b>DOMICILIO: </b> " . $rw_razon['domicilio'] . 
                "<br><b>TELEFONO: </b> " . $rw_razon['telefono'] . 
                "</pre>";
                echo $cadenaproveedor;
                ?>
            </td>
        </tr>
    </table>
    <br>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <td style="width: 35%;" class='midnight-blue'>USUARIO</td>
            <td style="width: 25%;" class='midnight-blue'>FECHA</td>
            <td style="width: 40%;" class='midnight-blue'>ESTADO</td>
        </tr>
        <tr>
            <td style="width: 35%;">
                <?php echo $_SESSION['usuario']; ?>
            </td>
            <td style="width: 25%;"><?= $fecha ?></td>
            <td style="width: 40%;">
                <?php
                if ($estado == 1) { echo "ACTIVO"; }
                elseif ($estado == 2) { echo "INACTIVO"; }
                ?>
            </td>
        </tr>
    </table>
    <br>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%; text-align: center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%; text-align: right" class='midnight-blue'>UNITARIO</th>
            <th style="width: 15%; text-align: right" class='midnight-blue'>SUBTOTAL</th>
        </tr>

        <?php
        $nums = 1;
        $sumador_total = 0;

        $insert = $factura->addFactura($numero_factura, $fecha, $idproveedor, $estado, $idusuario);
        $impuesto = 11;

        $arrDetalles = $JSONdetalle->getDetalles($sesion);
        foreach ($arrDetalles as $fila) {
            $idConcepto = $fila["idConcepto"];
            $idArticulo = $fila['idConcepto'];
            $cantidad = $fila['cantidad'];
            $concepto = $fila['concepto'];
            $precio_compra = $fila['unitario'];

            $insertdetail = $factura->addDetalleFactura($numero_factura, $idArticulo, $precio_compra, $cantidad, IMPUESTO);

            $precio_compra_f = number_format($precio_compra, 2);
            $precio_compra_r = str_replace(",", "", $precio_compra_f);
            $precio_total = $precio_compra_r * $cantidad;
            $precio_total_f = number_format($precio_total, 2);
            $precio_total_r = str_replace(",", "", $precio_total_f);
            $sumador_total += $precio_total_r;

            $clase = ($nums % 2 == 0) ? "clouds" : "silver";
        ?>

            <tr>
                <td class='<?php echo $clase; ?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
                <td class='<?php echo $clase; ?>' style="width: 60%; text-align: left"><?php echo $concepto; ?></td>
                <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $precio_compra_f; ?></td>
                <td class='<?php echo $clase; ?>' style="width: 15%; text-align: right"><?php echo $precio_total_f; ?></td>
            </tr>

        <?php
            $nums++;
        }

        $subtotal = number_format($sumador_total, 0, '.', '');
        $total_iva = ($subtotal / $impuesto);
        $total_iva = number_format($total_iva, 0, '.', '');
        $total_factura = $subtotal;
        ?>

        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">SUBTOTAL G.; </td>
            <td style="width: 15%; text-align: right;"> <?php echo number_format($subtotal, 0); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">IVA (<?php echo IMPUESTO; ?>)% G.; </td>
            <td style="width: 15%; text-align: right;"> <?php echo number_format($total_iva, 0); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="width: 85%; text-align: right;">TOTAL G.; </td>
            <td style="width: 15%; text-align: right;"> <?php echo number_format($total_factura, 0); ?></td>
        </tr>
    </table>

    <br><br><br>
    <div style="font-size: 11pt; text-align: center; font-weight: bold">Planilla de compra generada!</div>

</page>

<?php
$JSONdetalle->deleteAllDetalles($sesion);
?>
