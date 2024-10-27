<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$cantidad_detsalida = $_POST['cantidad_detsalida'];
$precio_salida = $_POST['precio_salida'];
$id_producto = $_POST['id_producto'];
$id_salida = $_POST['id_salida'];
$estado = 1;

$sql = "INSERT INTO detalle_salida(cantidad_detsalida, precio_salida, id_salida, id_producto, estado) 
VALUES('$cantidad_detsalida', '$precio_salida','$id_salida', '$id_producto',  '$estado')";

$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <?php
        $BuscadataProducto = "SELECT stock FROM productos WHERE id_producto='$id_producto'";
        $resultStock = $conn->query($BuscadataProducto);
        $row = $resultStock->fetch_assoc();
        $oldstock = $row['stock'];
        $nstock = $oldstock - $cantidad_detsalida;
        $sqlUpdStock = "UPDATE productos SET stock='$nstock' WHERE id_producto='$id_producto'";
        $conn->query($sqlUpdStock);    
    ?>
    <script>
        $(document).ready(function() {
            $("#DataPanelPreSalida").load("./views/salidas/presalida.php");
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