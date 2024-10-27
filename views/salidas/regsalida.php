<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMaxid = "SELECT MAX(id_salida) AS id_salida FROM salida";

$resultMaxId = $conn->query($sqlMaxid);
$rowMaxId = $resultMaxId->fetch_assoc();
$id_salida = $rowMaxId['id_salida'] + 1;
$id_usuario = $_SESSION['id_usuario'];
//$fecha_salida = $_POST['fecha_salida'];
//$hora = $_POST['hora'];
$id_tiposalida = $_POST['id_tiposalida'];
//$fecha_salida = date("Y-m-d H:i:s");
$estado = 0;
$sql = "INSERT INTO salida(id_salida, fecha_salida, id_tiposalida, id_usuario, estado) VALUES('$id_salida', NOW(),  '$id_tiposalida', '$id_usuario', '$estado')";

$result = $conn->query($sql);
?>
<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreSalida").load("./views/salidas/presalida.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al registrar salida');
            $("#sub-data").load("./views/salidas/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>