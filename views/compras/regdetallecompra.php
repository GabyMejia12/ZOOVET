<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$cantidad_detentrada = $_POST['cantidad_detentrada'];
$cantidad_medida = $_POST['cantidad_medida'];
$total = $_POST['total'];
$id_producto = $_POST['id_producto'];
$id_entrada = $_POST['id_entrada'];
$precio_compra = $_POST['precio_compra'];
$vencimiento = $_POST['vencimiento'];
$estado = 0;

$sql = "INSERT INTO detalle_entrada(cantidad_detentrada, cantidad_medida,total, id_producto, id_entrada, precio_compra, vencimiento,estado) 
VALUES('$cantidad_detentrada', '$cantidad_medida','$total', '$id_producto', '$id_entrada', '$precio_compra', '$vencimiento', '$estado')";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <?php
        $BuscadataProducto = "SELECT stock FROM productos WHERE id_producto='$id_producto'";
        $resultStock = $conn->query($BuscadataProducto);
        $row = $resultStock->fetch_assoc();
        $oldstock = $row['stock'];
        $nstock = $oldstock + $total;
        $sqlUpdStock = "UPDATE productos SET stock='$nstock' WHERE id_producto='$id_producto'";
        $conn->query($sqlUpdStock);    
    ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreCompra").load("./views/compras/precompra.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al agregar producto...');
            $("#sub-data").load("./views/compras/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>