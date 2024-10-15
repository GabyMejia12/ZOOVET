<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['idusuario'];
$ventasEstado0 = "SELECT * FROM entrada WHERE estado=0 AND id_usuario='$id_usuario'";
$result = $conn->query($ventasEstado0);
$row = $result->fetch_assoc();

echo $id_usuario;

$sql = "SELECT * FROM productos WHERE stock > 0 AND estado = 1";
$dataProductos = $conn->query($sql);

$sqlDV = "SELECT * FROM detalleventas WHERE idventa='$idventa' AND estado = 1";
$detallesVentas = $conn->query($sqlDV);

$contProd = 0;
$contProdDV = 0;
$contTproductos = 0;
$contTotalProductos = 0;
?>
<div class="card border-info text-white mb-9" style="width: 50rem;">
    <div class="card-header bg-info border-info">
        Registrar productos                            
    </div>
</div>