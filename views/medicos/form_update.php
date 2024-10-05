<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $id_veterinario = $_GET['id_veterinario'];
  $sql = "SELECT * FROM veterinario WHERE id_veterinario = '$id_veterinario'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $codigo_veterinario = $row['codigo_veterinario'];
  $nombre = $row['nombre']; 
  $apellido = $row['apellido']; 
   
?>
<input type="hidden" id="id_veterinario" name="id_veterinario" value="<?php echo $id_veterinario;?>">
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Código</b></span>
  <input type="text" class="form-control"  name="codigo_veterinario" id="codigo_veterinario" value="<?php echo $codigo_veterinario;?>" readonly>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombres</b></span>
  <input type="text" class="form-control"  name="nombre" id="nombre" value="<?php echo $nombre;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Apellidos</b></span>
  <input type="text" class="form-control"  name="apellido" id="apellido" value="<?php echo $apellido;?>">
</div>