<?php
@session_start();
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMascota = "SELECT * FROM mascota";
$DataMascota = $conn->query($sqlMascota);
?>

<form action="" method="post" autocomplete="off">
<h5>Datos del paciente</h5>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Fecha</b></span>
  <input type="date" class="form-control" placeholder="fecha" name="fecha" id="fecha">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Código Mascota</b></span>
  <input type="text" class="form-control" placeholder="codigo mascota" name="codigo_mascota" id="codigo_mascota">
  <ul id="lista"></ul>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Mascota</b></label>
    <select class="form-select" id="id_mascota" name="id_mascota">
        <option disabled selected>Seleccione Mascota</option>
        <?php foreach ($DataMascota as $result) : ?>
            <option value="<?php echo $result['id_mascota']; ?>" 
                data-nombre="<?php echo $result['codigo_mascota']; ?>" 
                data-apellido="<?php echo $result['nombre_mascota']; ?>">
                <?php echo $result['codigo_mascota'] . ' ' . $result['nombre_mascota']; ?>
            </option>
        <?php endforeach ?>
    </select>
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Peso</b></span>
  <input type="date" class="form-control" placeholder="nombres" name="fecha" id="fecha">
</div>
<h5>Datos de la consulta</h5>
<div class="input-group mb-3">
  <span class="input-group-text"><b>RX</b></span>
  <input type="text" class="form-control" placeholder="RX" name="RX" id="RX">
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><b>Tipo consulta</b></span>
  <input type="text" class="form-control" placeholder="peso" name="raza" id="raza">
</div>



<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>MV</b></span>
  <input type="text" class="form-control" placeholder="Medico" name="id_veterinario" id="id_veterinario" readonly>
</div>
</form>
<script>
  // Funciones JavaScript
  let codigosGenerados = new Set(); // Para almacenar los códigos generados


</script>

<script src="./public/js/peticiones.js"></script>

