<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <?php
        include 'header.php';
    ?>
    <title>CRUD PHP POO</title>
    <link rel="icon" href="favicon.ico" type="favicon.icon"/>


</head>

<body>
    <div class="container-login">
        <div class="wrap-login">
            <form class="login-form validate-form" id="formLogin" action="" method="post">
                <span class="login-form-title">ACCESO</span>

                <div class="wrap-input100" data-validate="Usuario incorrecto">
                    <input class="input100" type="text" id="nombre" name="nombre" placeholder="Usuario">
                    <span class="focus-efecto"></span>
                </div>

                <div class="wrap-input100" data-validate="Password incorrecto">
                    <input class="input100" type="password" id="clave" name="clave" placeholder="Contraseña">
                    <span class="focus-efecto"></span>
                </div>

                <div class="container-login-form-btn">
                    <div class="wrap-login-form-btn">
                        <div class="login-form-bgbtn"></div>
                        <button type="submit" name="submit" class="login-form-btn">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
    <?php
        include 'footer.php';
    ?>
</html>