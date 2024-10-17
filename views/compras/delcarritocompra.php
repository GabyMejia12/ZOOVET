<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_detentrada = $_POST['id_detentrada'];
$BuscadataDV = "SELECT * FROM detalle_entrada WHERE id_detentrada='$id_detentrada'";
$resultStock = $conn->query($BuscadataDV);
$rowDV = $resultStock->fetch_assoc();
$id_producto = $rowDV['id_producto'];
$total = $rowDV['total'];

$sql = "DELETE FROM detalle_entrada WHERE id_detentrada='$id_detentrada'";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE) : ?>
    <?php
    $BuscadataProducto = "SELECT stock FROM productos WHERE id_producto='$id_producto'";
    $resultStock = $conn->query($BuscadataProducto);
    $row = $resultStock->fetch_assoc();
    $oldstock = $row['stock'];
    $nstock = $oldstock - $total;
    $sqlUpdStock = "UPDATE productos SET stock='$nstock' WHERE id_producto='$id_producto'";
    $conn->query($sqlUpdStock);
    ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreCompra").load("./views/compras/precompra.php");
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