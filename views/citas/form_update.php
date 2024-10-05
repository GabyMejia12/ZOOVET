<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_cita = $_GET['id_cita'];

// Para tabla citas, trae la fecha, hora, id_mascota, y id_veterinario
$sqlCita = "SELECT * FROM cita WHERE id_cita = ?";
$stmt = $conn->prepare($sqlCita);
$stmt->bind_param("i", $id_cita);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$fecha = $row['fecha'];
$hora = $row['hora'];
$id_mascota = $row['id_mascota'];
$id_veterinario = $row['id_veterinario'];

// Traer información del veterinario
$sqlVet = "SELECT id_veterinario, nombre, apellido FROM veterinario";
$DataVeterinario = $conn->query($sqlVet);

// Traer información de las mascotas
$sqlMascota = "SELECT id_mascota, nombre_mascota FROM mascota";
$DataMascota = $conn->query($sqlMascota);
?>
<input type="hidden" id="id_cita" name="id_cita" value="<?php echo $id_cita; ?>">

<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Fecha</b></span>
  <input type="date" class="form-control" placeholder="" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Hora</b></span>
  <input type="time" class="form-control" placeholder="hora" name="hora" id="hora" value="<?php echo $hora; ?>">
</div>

<!-- Selector de Mascota -->
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Mascota</b></label>
  <select class="form-select" id="id_mascota" name="id_mascota">
    <option disabled selected>Seleccione Mascota</option>
    <?php while ($rowMascota = $DataMascota->fetch_assoc()) : ?>
      <option value="<?php echo $rowMascota['id_mascota']; ?>" <?php if ($rowMascota['id_mascota'] == $id_mascota) echo 'selected'; ?>>
        <?php echo $rowMascota['nombre_mascota']; ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>

<!-- Selector de Veterinario -->
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Veterinario</b></label>
  <select class="form-select" id="id_veterinario" name="id_veterinario">
    <option disabled selected>Seleccione Veterinario</option>
    <?php while ($rowVet = $DataVeterinario->fetch_assoc()) : ?>
      <option value="<?php echo $rowVet['id_veterinario']; ?>" <?php if ($rowVet['id_veterinario'] == $id_veterinario) echo 'selected'; ?>>
        <?php echo $rowVet['nombre'] . " " . $rowVet['apellido']; ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>
