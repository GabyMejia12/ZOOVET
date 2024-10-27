<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_detsalida = $_POST['id_detsalida'];
$BuscadataDV = "SELECT * FROM detalle_salida WHERE id_detsalida='$id_detsalida'";
$resultStock = $conn->query($BuscadataDV);
$rowDV = $resultStock->fetch_assoc();
$id_producto = $rowDV['id_producto'];
$cantidad_detsalida = $rowDV['cantidad_detsalida'];

$sql = "DELETE FROM detalle_salida WHERE id_detsalida='$id_detsalida'";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE) : ?>
    <?php
    $BuscadataProducto = "SELECT stock FROM productos WHERE id_producto='$id_producto'";
    $resultStock = $conn->query($BuscadataProducto);
    $row = $resultStock->fetch_assoc();
    $oldstock = $row['stock'];
    $nstock = $oldstock + $cantidad_detsalida;
    $sqlUpdStock = "UPDATE productos SET stock='$nstock' WHERE id_producto='$id_producto'";
    $conn->query($sqlUpdStock);
    ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreSalida").load("./views/salidas/presalida.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else : ?>
    <script>
        $(document).ready(function() {
            alert('Error al eliminar producto...');
            $("#sub-data").load("./views/ventas/preventa.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>