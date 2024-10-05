<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMas = "SELECT * FROM mascota";
$DataMascota = $conn->query($sqlMas);

$sqlVet = "SELECT * FROM veterinario";
$DataVeterinario = $conn->query($sqlVet);
?>

<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Fecha</b></span>
  <input type="date" class="form-control" placeholder="" name="fecha" id="fecha">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Hora</b></span>
  <input type="time" class="form-control" placeholder="hora" name="hora" id="hora">
</div>

<div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Mascota</b></label>
      <select class="form-select" id="id_mascota" name="id_mascota">
        <option disabled selected>Seleccione Mascota</option>
        <?php foreach ($DataMascota as $result) : ?>
          <option value="<?php echo $result['id_mascota']; ?>"><?php echo $result['nombre_mascota']; ?></option>
        <?php endforeach ?>
      </select>
</div>
<div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Veterinario</b></label>
      <select class="form-select" id="id_veterinario" name="id_veterinario">
        <option disabled selected>Seleccione Veterinario</option>
        <?php foreach ($DataVeterinario as $result) : ?>
          <option value="<?php echo $result['id_veterinario']; ?>"><?php echo $result['nombre']; ?></option>
        <?php endforeach ?>
      </select>
</div>




