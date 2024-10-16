<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_producto = $_GET['id_producto'];
$sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$codigo_producto = $row['codigo_producto'];
$nombre_producto = $row['nombre_producto'];
$descripcion = $row['descripcion'];
$medida = $row['medida'];
$stock = $row['stock'];
?>
<input type="hidden" value="<?php echo $id_producto; ?>" name="id_producto" id="id_producto">
<div class="input-group mb-3">
  <span class="input-group-text"><b>Código del producto</b></span>
  <input type="text" class="form-control" name="codigo_producto" id="codigo_producto" value="<?php echo $codigo_producto;?>" readonly>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombre Mascota</b></span>
  <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" value="<?php echo $nombre_producto;?>" readonly>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Descripción</b></span>
  <textarea class="form-control" name="descripcion" id="descripcion" readonly><?php echo $descripcion;?></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Medida</b></span>
  <input type="text" class="form-control" placeholder="#" name="medida" id="medida" value="<?php echo $medida;?>" readonly>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Stock</b></span>
  <input type="text" class="form-control" placeholder="00.00" name="stock" id="stock" value="<?php echo $stock;?>" readonly>
</div>