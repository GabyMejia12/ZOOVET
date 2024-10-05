<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $id_propietario = $_GET['id_propietario'];
  $sql = "SELECT * FROM propietario WHERE id_propietario = '$id_propietario'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nombre = $row['nombre'];
  $apellido = $row['apellido'];
  $telefono = $row['telefono'];  
  $direccion = $row['direccion'];
   
?>
<input type="hidden" id="id_propietario" name="id_propietario" value="<?php echo $id_propietario;?>">

<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Nombre</b></span>
  <input type="text" class="form-control" placeholder="Ingrese Nombres" name="nombre" id="nombre" value="<?php echo $nombre;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Apellido</b></span>
  <input type="text" class="form-control" placeholder="Ingrese Apellidos" name="apellido" id="apellido" value="<?php echo $apellido;?>"> 
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Telefono</b></span>
  <input type="number" class="form-control" placeholder="7777-7777" name="telefono" id="telefono" value="<?php echo $telefono;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Dirección</b></span>
  <textarea class="form-control" name="direccion" placeholder="Ingrese dirección" id="direccion"  ><?php echo $direccion;?></textarea>
</div>
