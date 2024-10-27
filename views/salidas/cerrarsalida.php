<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_salida = $_POST['id_salida'];
$sql = "UPDATE salida SET estado=1 WHERE id_salida='$id_salida'";
$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            let id_salida = '<?php echo $id_salida;?>';
            $("#sub-data").load("./views/salidas/principal.php?id_salida=" + id_salida);
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al cerrar venta...');
            $("#sub-data").load("./views/salidas/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>