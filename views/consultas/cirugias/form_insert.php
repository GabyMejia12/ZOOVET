<?php
@session_start();

include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMascota = "SELECT * FROM mascota";
$DataMascota = $conn->query($sqlMascota);

$sqlProd = "SELECT * FROM productos";
$DataProd = $conn->query($sqlProd);

$sqltipoConsulta = "SELECT * FROM tipo_consulta WHERE id_tipoconsulta=3";
$DataCon = $conn->query($sqltipoConsulta);
$row = $DataCon->fetch_assoc();
$nombre_consulta = $row['nombre_consulta'];
$id_tipoconsulta = $row['id_tipoconsulta'];

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];

?>
<!--ACTUALIZACION DE DATOS A LA TABLA MASCOTA-->
<h5>Datos del paciente</h5>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Código Mascota</b></span>
  <input type="text" class="form-control" placeholder="codigo mascota" name="codigo_mascota" id="codigo_mascota">
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
  <input type="text" class="form-control" placeholder="Ingrese peso de la mascota" name="peso" id="peso">
</div>

<!--DATOS DE LA CONSULTA - REGISTROS QUE VAN A LA TABLA CONSULTA-->
<h5>Datos de la consulta</h5>
<div class="input-group mb-3">
  <span class="input-group-text"><b>RX</b></span>
  <input type="text" class="form-control" placeholder="RX" name="RX" id="RX">
</div>
<!---tipo consulta-->
<div class="input-group mb-3">
  <span class="input-group-text"><b>Tipo consulta</b></span>
  <input type="text" class="form-control" value="<?php echo $nombre_consulta; ?>" placeholder="consulta" readonly>
</div>
<input type="hidden" id="id_tipoconsulta" name="id_tipoconsulta" value="<?php echo $id_tipoconsulta ?>">

<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>MV</b></span>
  <input type="text" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" placeholder="Medico" readonly>
</div>
<input type="hidden" id="id_veterinario" name="id_veterinario" value="<?php echo $_SESSION['id_usuario']; ?>">

<!--DATOS QUE VAN A INGRESARCE A LA TABLA DETALLE SALIDA Y ACTUALIZARSE EN TABLA PRODUCTOS-->
<h5>Medicamentos Utilizados</h5>
<!-- Campo oculto para almacenar el ID del veterinario -->
<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
        <div id="medicamentos-container">
            <div class="medicamento" class="input-group">
                <label class="input-group-text">Medicamento:</label>
                <select class="medicamento-id" id="id_producto" name="id_producto">
                    <option disabled selected>Seleccione medicamentos</option>
                    <?php foreach ($DataProd as $result) : ?>
                    <option value="<?php echo $result['id_producto']; ?>"><?php echo $result['nombre_producto']; ?></option>
                    <?php endforeach ?>
                </select>

                <label>Cantidad:</label>
                <input type="number" class="cantidad" min="1" value="1"><br>
            </div>
        </div>
        <button type="button btn-succes" id="agregar-medicamento">Agregar otro medicamento</button><br><br>
<script>
// Funciones JavaScript
  let codigosGenerados = new Set(); // Para almacenar los códigos generados

  $(document).ready(function() {
            // Agregar otro medicamento
            $('#agregar-medicamento').on('click', function() {
                $('#medicamentos-container').append(`
                    <div class="medicamento">
                        <label>Medicamento:</label>
                        <select class="medicamento-id" id="id_propietario" name="id_propietario">
                    <option disabled selected>Seleccione medicamentos</option>
                    <?php foreach ($DataProd as $result) : ?>
                    <option value="<?php echo $result['id_producto']; ?>"><?php echo $result['nombre_producto']; ?></option>
                    <?php endforeach ?>
                </select>
                        <label>Cantidad:</label>
                        <input type="number" class="cantidad" min="1" value="1"><br>
                    </div>
                `);
            });

    

  });


</script>

<!--<script src="./public/js/peticiones.js"></script>

