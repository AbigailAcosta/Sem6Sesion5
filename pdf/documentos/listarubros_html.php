<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <title>Generar PDF con PHP</title>
        <style type="text/css">
            #cabecera {
                background: #eee;
                padding: 20px;
            }
            h2, h3 {
                float: left;
            }
            #cabecera img {
                width: 140px;
                float: right;
            }
        </style>
    </head>
    <body>
        <div id="cabecera">
            <!-- <img src="php.png" /> -->
            <h2>Este PDF ha sido generado desde PHP</h2>
            <h3>LP III -
                <a href="https://www.utic.edu.py/v7/">
                    UTIC CZU
                </a>
            </h3>
        </div>
            <p><h2>Lista ordenada de Rubros:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include dirname(__DIR__).'../../class/class.rubros.php';
                        $rubro = new Rubro();
                        $resultado = $rubro->getRubros();

                        foreach ($resultado as $fila) { ?>
                        <tr>
                            <td><?=$fila['idRubro'] ?></td>
                            <td><?=$fila['nombre'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </p>
        </body>
    </html>
