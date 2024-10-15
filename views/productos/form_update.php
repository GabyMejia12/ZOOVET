<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_producto = $_GET['id_producto'];
$sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nombre_producto = $row['nombre_producto'];
$descripcion = $row['descripcion'];
$cantidad = $row['cantidad'];
$precio = $row['precio'];
$estado = $row['estado'];
$vestado = ($estado == 1) ? 'Disponible' : 'No Disponible';



?>
<input type="hidden" value="<?php echo $id_producto; ?>" name="id_producto" id="id_producto">
<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombre Mascota</b></span>
  <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" value="<?php echo $nombre_producto;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Descripción</b></span>
  <textarea class="form-control" name="descripcion" id="descripcion" ><?php echo $descripcion;?></textarea>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Cantidad</b></span>
  <input type="number" class="form-control" placeholder="#" name="cantidad" id="cantidad" value="<?php echo $cantidad;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Precio</b></span>
  <input type="text" class="form-control" placeholder="00.00" name="precio" id="precio" value="<?php echo $precio;?>">
</div>