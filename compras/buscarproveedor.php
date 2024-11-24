<?php
include '../class/class.personas.php';
$Persona = new Persona();

$idpersona = $_POST['idpersona'];

if ($idpersona != null) {
    $query = $Persona->getPersona($idpersona);

    while ($fila = mysqli_fetch_array($query)) {
?>
        <script type="text/javascript">
            $('#telefono').val(<?= json_encode($fila['telefono']) ?>);
            $('#cedula').val(<?= json_encode($fila['ciruc']) ?>);
        </script>
<?php
    }
} else {
?>
    <script type="text/javascript">
        $('#telefono').val('');
        $('#ciruc').val('');
    </script>
<?php
}
?>
