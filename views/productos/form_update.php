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



?>
<input type="hidden" value="<?php echo $id_producto; ?>" name="id_producto" id="id_producto">
<div class="input-group mb-3">
  <span class="input-group-text"><b>Código producto</b></span>
  <input type="text" class="form-control" name="codigo_producto" id="codigo_producto" readonly value="<?php echo $codigo_producto;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombre Producto</b></span>
  <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" value="<?php echo $nombre_producto;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Descripción</b></span>
  <textarea class="form-control" name="descripcion" id="descripcion" ><?php echo $descripcion;?></textarea>
</div>

<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01"><b>Presentación</b></label>
  </div>
  <select class="custom-select" id="medida" name="medida">
    <option value="" <?php echo ($medida == "") ? "selected" : ""; ?>>Tipo medidas</option>
    <option value="ML" <?php echo ($medida == "ML") ? "selected" : ""; ?>>ML</option>
    <option value="Tabletas" <?php echo ($medida == "Tabletas") ? "selected" : ""; ?>>Tabletas</option>
    <option value="Gramos" <?php echo ($medida == "Gramos") ? "selected" : ""; ?>>Gramos</option>
  </select>
</div>

