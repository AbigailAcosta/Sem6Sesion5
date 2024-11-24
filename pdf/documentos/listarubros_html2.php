<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
    <page_header><br><br>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left; width: 33%">Listado de Rubros</td>
                <td style="text-align: center; width: 34%">RUBROS</td>
                <td style="text-align: right; width: 33%"><?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left; width: 50%">Leng. Prog. III</td>
                <td style="text-align: right; width: 50%">página [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>

    <br><br>
    <br>
    <table style="width: 80%; border: solid 1px #5544DD; border-collapse: collapse" align="center">
        <thead>
            <tr>
                <th style="width: 30%; text-align: left; border: solid 1px #900C3F; background: #900C3F; color: #FFFFFF;"><span style="color: #FFFFFF;">CODIGO</span></th>
                <th style="width: 30%; text-align: left; border: solid 1px #900C3F; background: #900C3F; color: #FFFFFF;"><span style="color: #FFFFFF;">NOMBRE</span></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include dirname(__DIR__).'../../class/class.rubros.php';
            $rubro = new Rubro();
            $resultado = $rubro->getRubros();

            foreach ($resultado as $fila) {
            ?>
            <tr>
                <td style="width: 30%; text-align: left; border: solid 1px #900C3F">
                    <?=$fila['idRubro'] ?>
                </td>
                <td style="width: 70%; text-align: left; border: solid 1px #900C3F">
                    <?=$fila['nombre'] ?>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <!-- <tfoot>
            <tr>
                <th style="width: 30%; text-align: left; border: solid 1px #900C3F; background: #CCFFCC">Footer 1</th>
                <th style="width: 30%; text-align: left; border: solid 1px #900C3F; background: #CCFFCC">Footer 2</th>
            </tr>
        </tfoot> -->
    </table>
</page>
