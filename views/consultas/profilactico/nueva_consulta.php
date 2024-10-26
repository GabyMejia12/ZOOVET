<?php
@session_start();

include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMascota = "SELECT * FROM mascota";
$DataMascota = $conn->query($sqlMascota);

$sqlProd = "SELECT * FROM productos";
$DataProd = $conn->query($sqlProd);

$sqltipoConsulta = "SELECT * FROM tipo_consulta WHERE id_tipoconsulta=2";
$DataCon = $conn->query($sqltipoConsulta);
$row = $DataCon->fetch_assoc();
$nombre_consulta = $row['nombre_consulta'];
$id_tipoconsulta = $row['id_tipoconsulta'];

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div class="card col-md-12">
  <h5 class="card-header">Registrar Nueva Consulta</h5>
  <div class="card-body">
  <form class="row g-3">
<span class="input-group-text"><b>
    <h4>DATOS DEL PACIENTE</h4></b>
</span>
<!--ACTUALIZACION DE DATOS A LA TABLA MASCOTA-->

<div class="col-md-6">
  <label for="inputEmail4" class="form-label"><b>Código Mascota:</b></label>
  <input type="text" class="form-control" placeholder="codigo mascota" name="codigo_mascota" id="codigo_mascota">
</div>
<div class="col-md-6">
    <label class="form-label" aria-label=".form-select-lg example"><b>Mascota:</b></label>
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
<div class="col-md-6">
  <span class="form-label"><b>Peso</b></span>
  <input type="text" class="form-control" placeholder="Ingrese peso de la mascota" name="peso" id="peso">
</div>

<!--DATOS DE LA CONSULTA - REGISTROS QUE VAN A LA TABLA CONSULTA-->
<h5>Datos de la consulta</h5>
<div class="col-md-12">
  <span class="form-label"><b>RX</b></span>
  <textarea type="text" class="form-control" placeholder="Ingresa el detalle médico aquí..." name="RX" id="RX"></textarea>
</div>

<div class="col-md-6">
  <span class="form-label"><b>Tipo consulta</b></span>
  <input type="text" class="form-control" value="<?php echo $nombre_consulta; ?>" placeholder="consulta" readonly>
</div>
<input type="hidden" id="id_tipoconsulta" name="id_tipoconsulta" value="<?php echo $id_tipoconsulta ?>">

<div class="col-md-6">
  <span class="form-label" id="basic-addon1"><b>MV</b></span>
  <input type="text" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" placeholder="Medico" readonly>
</div>
<input type="hidden" id="id_veterinario" name="id_veterinario" value="<?php echo $_SESSION['id_usuario']; ?>">

<!--DATOS QUE VAN A INGRESARCE A LA TABLA DETALLE SALIDA Y ACTUALIZARSE EN TABLA PRODUCTOS-->
<span class="input-group-text"><b>
    <h4>MEDICAMENTOS UTILIZADOS</h4></b>
</span>
<!-- Campo oculto para almacenar el ID del veterinario -->
<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
        

<div id="medicamentos-container" class="col-md-12">
        <div class="medicamento">
            <label class="form-label col-md-4"><b>Medicamento:</b></label>
            <select class="medicamento-id form-select col-md-4" id="id_producto" name="id_producto">
                <option disabled selected>Seleccione medicamentos</option>
                <?php foreach ($DataProd as $result) : ?>
                <option value="<?php echo $result['id_producto']; ?>"><?php echo $result['nombre_producto']; ?></option>
                <?php endforeach ?>
                </select>
                <br>
                <label class="col-md-4"><b>Cantidad:</b></label>
                <input type="number" class="cantidad form-control col-md-4" min="1" value="1"><br>
            </div>
        </div>
        
        <div  class="col-12">
        <button type="button" class="btn btn-primary" id="agregar-medicamento">Agregar otro medicamento</button><br><br>
        </div>
        <div  class="col-12">
        <button type="button" class="btn btn-success" id="Guardar">Registrar Consulta</button>
        </div>

        </form>
  </div>
</div>
</body>
</html>

<script>
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



        // Proceso Insert
        $("#BtnNewConP").click(function() {
            if ($('#RX').val() === '' || $('#peso').val() === '' || $('#id_tipoconsulta').val() === '' || $('#id_veterinario').val() === '' || $('#id_mascota').val() === '' || $('#id_usuario').val() === '') {
                alert('Por favor completa todos los campos.');
                return;
            }

            let RX, peso, id_tipoconsulta, id_veterinario, id_mascota, id_usuario, medicamentos;
            RX = $('#RX').val();
            peso = $('#peso').val();
            id_tipoconsulta = $('#id_tipoconsulta').val();
            id_veterinario = $('#id_veterinario').val();
            id_mascota = $('#id_mascota').val();
            id_usuario = $('#id_usuario').val();
            medicamentos = [];
                $('.medicamento').each(function() {
                    let medicamento_id = $(this).find('.medicamento-id').val();
                    let cantidad = $(this).find('.cantidad').val();
                    medicamentos.push({ id_producto: medicamento_id, cantidad_detsalida: cantidad });
                });

            var formData = {
                RX: RX,
                peso : peso,
                id_tipoconsulta: id_tipoconsulta,
                id_veterinario: id_veterinario,
                id_mascota: id_mascota,
                id_usuario: id_usuario,
                medicamentos: medicamentos
            };

            Swal.fire({
            title: 'Registrar Consulta',
            text: "¿Desea registrar la consulta?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: './views/consultas/profilactico/insert.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                        if (response.success) {
                    Swal.fire('Éxito', response.message, 'success');
                    $('#RX').val('');
                    $('#peso').val('');
                    $('#id_tipoconsulta').val('');
                    $('#id_veterinario').val('');
                    $('#id_mascota').val('');
                    $('#id_usuario').val('');
                    $('#medicamentos').val('');
                    $("#sub-data").load("./views/consultas/profilactico/principal.php");
                } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Ocurrió un error en el servidor: ' + error, 'error');
                    }
                });
            } 
        });
    });
});


</script>

<!--<script src="./public/js/peticiones.js"></script>

