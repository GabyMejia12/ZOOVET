<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMaxid = "SELECT MAX(id_entrada) AS id_entrada FROM entrada";

$resultMaxId = $conn->query($sqlMaxid);
$rowMaxId = $resultMaxId->fetch_assoc();
$id_entrada = $rowMaxId['id_entrada'] + 1;
$id_usuario = $_SESSION['id_usuario'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
//$fecha = date("Y-m-d H:i:s");
$estado = 0;
$sql = "INSERT INTO entrada(id_entrada, fecha, hora, id_usuario,  estado) VALUES('$id_entrada', '$fecha', '$hora','$id_usuario', '$estado')";

$result = $conn->query($sql);
?>
<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreCompra").load("./views/compras/precompra.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al registrar compra...');
            $("#sub-data").load("./views/compras/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>