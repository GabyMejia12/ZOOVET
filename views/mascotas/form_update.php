<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_mascota = $_GET['id_mascota'];
//Traer información del propietario
$sqlProp = "SELECT * FROM propietario";
$DataPropietarios = $conn->query($sqlProp);



// Traer información de las mascotas
$sqlMascota = "SELECT * FROM mascota WHERE id_mascota = '$id_mascota'";
$result = $conn->query($sqlMascota);
$row = $result->fetch_assoc();
$nombre_mascota = $row['nombre_mascota'];
$peso = $row['peso'];
$edad = $row['edad'];
$especie = $row['especie'];
$raza = $row['raza'];
$sexo = $row['sexo'];
$descripcion = $row['descripcion'];
$codigo_mascota = $row['codigo_mascota'];
$id_propietario = $row['id_propietario'];
?>
<input type="hidden" id="id_mascota" name="id_mascota" value="<?php echo $id_mascota; ?>">


<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombre Mascota</b></span>
  <input type="text" class="form-control" placeholder="Ingrese nombre mascota" name="nombre_mascota" id="nombre_mascota" value="<?php echo $nombre_mascota;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Peso</b></span>
  <input type="text" class="form-control" placeholder="peso" name="peso" id="peso" value="<?php echo $peso;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Edad</b></span>
  <input type="text" class="form-control" placeholder="edad" name="edad" id="edad" value="<?php echo $edad;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Especie</b></span>
  <input type="text" class="form-control" placeholder="especie" name="especie" id="especie" value="<?php echo $especie;?>">
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><b>Raza</b></span>
  <input type="text" class="form-control" placeholder="peso" name="raza" id="raza" value="<?php echo $raza;?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Sexo</b></span>
  <select class="form-select" name="sexo" id="sexo" required>
    <option disabled>Seleccione Sexo</option>
    <option value="macho" <?php echo ($sexo === 'macho') ? 'selected' : ''; ?>>Macho</option>
    <option value="hembra" <?php echo ($sexo === 'hembra') ? 'selected' : ''; ?>>Hembra</option>
  </select>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Descripción</b></span>
  <textarea class="form-control" name="descripcion"  id="descripcion" ><?php echo $descripcion;?>"</textarea>
</div>
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Propietario</b></label>
  <select class="form-select" id="id_propietario" name="id_propietario" required>
    <option disabled>Seleccione Propietario</option>
    <?php foreach ($DataPropietarios as $result) : ?>
      <option value="<?php echo $result['id_propietario']; ?>" <?php echo ($id_propietario === $result['id_propietario']) ? 'selected' : ''; ?>>
        <?php echo $result['nombre']; ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Codigo Mascota</b></span>
  <input type="text" class="form-control" placeholder="Ingrese Nombres" name="codigo_mascota" id="codigo_mascota" readonly value="<?php echo $codigo_mascota;?>">
</div>



