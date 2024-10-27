<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_entrada = $_POST['id_entrada'];
$sql = "UPDATE entrada SET estado=1 WHERE id_entrada='$id_entrada'";
$result = $conn->query($sql);
?>

<?php if ($result === TRUE): ?>
    <script>
        $(document).ready(function() {
            let id_entrada = '<?php echo $id_entrada;?>';
            $("#sub-data").load("./views/compras/principal.php?id_entrada=" + id_entrada);
        });
    </script>
    <?php cerrar_db(); ?>
<?php else: ?>
    <script>
        $(document).ready(function() {
            alert('Error al cerrar venta...');
            $("#sub-data").load("./views/compras/principal.php");
        });
    </script>
    <?php cerrar_db(); ?>
<?php endif ?>