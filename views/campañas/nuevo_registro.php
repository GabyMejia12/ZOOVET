<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Consultas a la base de datos
$sqlProd = "SELECT * FROM productos WHERE stock > 0 AND estado = 1";
$DataProd = $conn->query($sqlProd);

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Registrar Consulta</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-sm-10 text-center">
                <h2>Consultas en Campañas</h2>
            </div>
            <div class="col-sm-2 text-right">
                <a href="#" id="BtnVolver" class="btn btn-success d-flex align-items-center">
                    <i class="material-icons me-2">arrow_back</i> Regresar
                </a>
            </div>
        </div>
        
        <div class="card">
            <h5 class="card-header text-center">Información de registro</h5>
            <div class="card-body">
                <form id="consulta-form" class="row g-3">
                <div class="col-md-12 mt-4">
                        <h4 class=" card-header text-center">Datos del paciente</h4>
                    </div>
                    <!-- Formulario de datos del paciente -->
                    <div class="col-md-6">
                        <label class="form-label"><b>Nombre del Propietario:</b></label>
                        <input type="text" class="form-control" placeholder="Nombre del propietario" name="nombre_propietario" id="nombre_propietario" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><b>Teléfono de contacto:</b></label>
                        <input type="text" class="form-control" placeholder="Teléfono de contacto" name="telefono" id="telefono" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><b>Nombre de la Mascota:</b></label>
                        <input type="text" class="form-control" placeholder="Nombre de la mascota" name="nombre_mascota" id="nombre_mascota" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><b>Peso:</b></label>
                        <input type="text" class="form-control" placeholder="Ingrese peso de la mascota" name="peso" id="peso" required>
                    </div>
                    <div class="col-md-12 mt-4">
                        <h4 class=" card-header text-center">Datos del procedimiento</h4>
                    </div>
                    <!-- Formulario de datos de la consulta -->
                    <div class="col-md-6">
                        <label class="form-label"><b>Tipo Consulta:</b></label>
                        <select class="form-control" id="id_tipoconsulta" name="id_tipoconsulta" required>
                            <option value="Castración">Castración</option>
                            <option value="Esterilización">Esterilización</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label"><b>RX</b></label>
                        <textarea class="form-control" placeholder="Ingresa el detalle médico aquí..." name="RX" id="RX" required></textarea>
                    </div>
                    <input type="hidden" id="id_veterinario" name="id_veterinario" value="<?php echo $id_usuario; ?>">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>">

                    <!-- Formulario de medicamentos -->
                    <div class="col-md-12 mt-4">
                        <h4 class=" card-header text-center">Medicamentos Utilizados</h4>
                    </div>
                    <div id="medicamentos-container" class="col-md-12">
                        <div class="medicamento mb-3">
                            <label class="form-label"><b>Medicamento:</b></label>
                            <select class="medicamento-id form-select" id="id_producto" name="id_producto[]" required>
                                <option disabled selected>Seleccione medicamentos</option>
                                <?php foreach ($DataProd as $result): ?>
                                    <option value="<?php echo $result['id_producto']; ?>"><?php echo $result['nombre_producto']; ?></option>
                                <?php endforeach; ?>
                            </select><br>
                            <label class="form-label mt-2"><b>Cantidad:</b></label>
                            <input type="number" class="cantidad form-control" name="cantidad[]" min="1" required>
                            <label class="form-label mt-2"><b>Precio venta:</b></label>
                            <input type="text" class="precio_compra form-control" name="precio_compra[]" required>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" id="agregar-medicamento">Agregar otro medicamento</button>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-success" id="guardarCampaña">Registrar Consulta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
$(document).ready(function() {
    // Agregar otro medicamento
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
                <input type="text" class="precio_compra form-control col-md-4" value="1"><br>
            </div>
        `);
    });

    // Proceso Insert
    $("#guardarCampaña").click(function() {
        if ($('#nombre_propietario').val() === '' || 
            $('#telefono').val() === '' || 
            $('#nombre_mascota').val() === '' || 
            $('#peso').val() === '' || 
            $('#id_tipoconsulta').val() === '' || 
            $('#id_veterinario').val() === '' || 
            $('#id_usuario').val() === '') {
            alert('Por favor completa todos los campos.');
            return;
        }

        let nombre_propietario = $('#nombre_propietario').val();
        let telefono = $('#telefono').val();
        let nombre_mascota = $('#nombre_mascota').val();
        let peso = $('#peso').val();
        let id_tipoconsulta = $('#id_tipoconsulta').val();
        let id_veterinario = $('#id_veterinario').val();
        let id_usuario = $('#id_usuario').val();
        let RX = $('#RX').val();
        
        let medicamentos = [];
        $('.medicamento').each(function() {
            let medicamento_id = $(this).find('.medicamento-id').val();
            let cantidad = $(this).find('.cantidad').val();
            let precio_compra = $(this).find('.precio_compra').val();
            medicamentos.push({ id_producto: medicamento_id, cantidad_detsalida: cantidad, precio_compra: precio_compra });
        });

        var formData = {
            nombre_propietario: nombre_propietario,
            telefono: telefono,
            nombre_mascota: nombre_mascota,
            peso: peso,
            id_tipoconsulta: id_tipoconsulta,
            id_veterinario: id_veterinario,
            id_usuario: id_usuario,
            RX: RX,
            medicamentos: medicamentos
        };
        
        console.log("Datos a enviar:", formData);
        Swal.fire({
            title: 'Registrar Consulta en campaña',
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
                    url: './views/campañas/guardar_campania.php',
                    //data: JSON.stringify(formData), // Asegúrate de enviar en formato JSON
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Éxito', response.message, 'success');
                            // Limpiar los campos después de registrar
                            $('#nombre_propietario').val('');
                            $('#telefono').val('');
                            $('#nombre_mascota').val('');
                            $('#peso').val('');
                            $('#id_tipoconsulta').val('');
                            $('#id_veterinario').val('');
                            $('#id_usuario').val('');
                            $('#RX').val('');
                            $('#medicamentos-container').empty(); // Limpiar medicamentos
                            $("#sub-data").load("./views/campañas/principal.php");
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', xhr.responseText); // Muestra la respuesta del servidor
                        console.error('Detalles del error:', error); // Muestra el mensaje de error
                        Swal.fire('Error', 'Ocurrió un error en el servidor: ' + error, 'error');
                    }
                });
            } 
        });
    });
});
</script>
<script>
    // Al hacer clic en el botón "Regresar"
    $("#BtnVolver").click(function() {
        // Cargar el contenido del archivo principal en #sub-data
        $("#sub-data").load("./views/campañas/principal.php");
        return false; // Evitar la acción por defecto del enlace
    });
</script>

