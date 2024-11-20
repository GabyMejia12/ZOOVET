<?php
@session_start();

include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlMascota = "SELECT * FROM mascota";
$DataMascota = $conn->query($sqlMascota);

$sqlProd = "SELECT * FROM productos WHERE stock > 0 AND estado = 1";
$DataProd = $conn->query($sqlProd);

$sqltipoConsulta = "SELECT * FROM tipo_consulta WHERE id_tipoconsulta=1";
$DataCon = $conn->query($sqltipoConsulta);
$row = $DataCon->fetch_assoc();
$nombre_consulta = $row['nombre_consulta'];
$id_tipoconsulta = $row['id_tipoconsulta'];

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];

?>
<!--ACTUALIZACION DE DATOS A LA TABLA MASCOTA-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Carga jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Luego, carga jQuery UI CSS y JavaScript -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


</head>
<body>
<div class="card col-md-12">
  <h5 class="card-header">Registrar Nueva Consulta</h5>
  <div class="card-body">
  <form class="row g-3">
<span class="input-group-text"><b>
    <h4>DATOS DEL PACIENTE</h4></b>
</span>
<div class="col-md-6">
  <label for="inputEmail4" class="form-label"><b>Código Mascota:</b></label>
  <input type="text" class="form-control" placeholder="código mascota" name="codigo_mascota" id="codigo_mascota">
</div>

<div class="col-md-6">
    <label for="nombre_mascota" class="form-label"><b>Nombre Mascota:</b></label>
    <input type="text" class="form-control" name="id_mascota" id="id_mascota" readonly>
</div>
<br><br>
<div class="col-md-6">
  <span class="form-label"><b>Peso:</b></span>
  <input type="text" class="form-control" placeholder="Ingrese peso de la mascota" name="peso" id="peso">
</div>

<!--DATOS DE LA CONSULTA - REGISTROS QUE VAN A LA TABLA CONSULTA-->
<span class="input-group-text"><b>
    <h4>DATOS DE LA CONSULTA</h4></b>
</span>
<div class="col-md-12">
  <span class="form-label"><b>RX</b></span>
  <textarea type="text" class="form-control" placeholder="Ingresa el detalle médico aquí..." name="RX" id="RX"></textarea>
</div>
<!---tipo consulta-->
<div class="col-md-6">
  <span class="form-label"><b>Tipo consulta:</b></span>
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
                <input type="number" class="cantidad form-control col-md-4" min="0.5" value="1"><br>
                <label class="col-md-4"><b>Precio venta:</b></label>
                <input type="text" class="precio_compra form-control col-md-4" min="1" value="1"><br>
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

    $('#agregar-medicamento').on('click', function() {
                $('#medicamentos-container').append(`
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
                <label class="col-md-4"><b>Precio venta:</b></label>
                <input type="text" class="precio_compra form-control col-md-4" min="1" value="1"><br>
                </div>
                `);
            });

    
    // Proceso Insert
    $("#Guardar").click(function() {
        if ($('#RX').val() === '' || $('#peso').val() === '' || $('#id_tipoconsulta').val() === '' || $('#id_veterinario').val() === '' || $('#codigo_mascota').val() === '' || $('#id_usuario').val() === '') {
            alert('Por favor completa todos los campos.');
            return;
        }

        let RX = $('#RX').val();
        let peso = $('#peso').val();
        let id_tipoconsulta = $('#id_tipoconsulta').val();
        let id_veterinario = $('#id_veterinario').val();
        let codigo_mascota = $('#codigo_mascota').val();
        let id_usuario = $('#id_usuario').val();

        let medicamentos = [];
        $('.medicamento').each(function() {
            let medicamento_id = $(this).find('.medicamento-id').val();
            let cantidad = $(this).find('.cantidad').val();
            let precio_compra = $(this).find('.precio_compra').val();
            medicamentos.push({ id_producto: medicamento_id, cantidad_detsalida: cantidad, precio_compra:precio_compra});
        });

        let formData = {
            RX: RX,
            peso: peso,
            id_tipoconsulta: id_tipoconsulta,
            id_veterinario: id_veterinario,
            codigo_mascota: codigo_mascota,
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
                    url: './views/consultas/general/insertPrueba.php',
                    data: formData,
                    dataType: 'json',  // Cambiado a 'json'
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Éxito', response.message, 'success');
                            $('#RX').val('');
                            $('#peso').val('');
                            $('#id_tipoconsulta').val('');
                            $('#id_veterinario').val('');
                            $('#codigo_mascota').val('');
                            $('#id_usuario').val('');
                            $('#medicamentos').val('');
                            $("#sub-data").load("./views/consultas/general/principal.php");
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
//autocomplete mascota
$(document).ready(function() {
    $("#codigo_mascota").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "./views/consultas/general/getMascotas.php",
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            // Al seleccionar, coloca el código en el campo de código y el nombre en el campo de nombre
            $("#codigo_mascota").val(ui.item.value);
            $("#id_mascota").val(ui.item.nombre_mascota);  // Completa el campo de nombre
            return false;
        }
    });
});

</script>