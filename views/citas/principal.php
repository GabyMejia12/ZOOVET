<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT a.id_cita, a.fecha, a.hora, b.nombre_mascota, c.nombre 
        FROM cita AS a 
        INNER JOIN mascota AS b ON a.id_mascota = b.id_mascota
        INNER JOIN veterinario AS c ON a.id_veterinario = c.id_veterinario";

$result = $conn->query($sql);
$cont = 0;

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Incluye Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Incluye Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div>
<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Citas</h2>
                    </div>
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewCita">
                            <i class="material-icons">&#xE147;</i> <span>Agendar Nueva Cita</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelCitas">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 80%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Mascota</th>
                    <th>Veterinario</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td><?php echo $data['hora']; ?></td>
                        <td><?php echo $data['nombre_mascota']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateCita" id_cita="<?php echo $data['id_cita']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                        <!--td>
                        <?php //if ($data['estado'] == 1) : 
                        ?>
                            <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-user-large-slash"></i></a>
                        <?php //else : 
                        ?>
                            <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-user-check"></i></a>
                        <?php //endif 
                        ?>
                    </td -->
                        <td>
                            
                                <a href="" class="btn text-white BtnDelCita" id_cita="<?php echo $data['id_cita']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-user-xmark"></i></a>
                            
                            
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="clearfix">
        <div class="hint-text">Mostrando <b><?php echo $cont; ?></b> de <b>25</b></div>
        <ul class="pagination">
        <li class="page-item disabled"><a href="#">Anterior</a></li>
        <li class="page-item"><a href="#" class="page-link">1</a></li>
        <li class="page-item active"><a href="#" class="page-link">2</a></li>
        <li class="page-item"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link">Siguiente</a></li>
        </ul>
        </div>
</div>
            </div>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran datos</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        //
        $("#BtnNewCita").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Cita';
            $("#DataModalPrincipal").load("./views/citas/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });


        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#fecha').val() === '' || $('#hora').val() === '' || $('#id_mascota').val() === '' || $('#id_veterinario').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let fecha, hora, id_mascota, id_veterinario;
            fecha = $('#fecha').val();
            hora = $('#hora').val();
            id_mascota = $('#id_mascota').val();
            id_veterinario = $('#id_veterinario').val();
           

            var formData = {

                fecha: fecha,
                hora: hora,
                id_mascota: id_mascota,
                id_veterinario: id_veterinario
            };
            $.ajax({
                type: 'POST',
                url: './views/citas/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#fecha').val('');
                    $('#hora').val('');
                    $('#id_mascota').val('');
                    $('#id_veterinario').val('');
                    $("#DataPanelCitas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        //Boton actualizar
        $(".BtnUpdateCita").click(function() {
            let id_cita = $(this).attr("id_cita");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de cita';
            $("#DataModalPrincipal").load("./views/citas/form_update.php?id_cita=" + id_cita);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#fecha').val() === '' || $('#hora').val() === '' || $('#id_mascota').val() === '' || $('#id_veterinario').val() === '') {
                //alert('Por favor completa todos los campos.');
                return;
            }
            let id_cita,fecha, hora, id_mascota, id_veterinario;
            id_cita = $('#id_cita').val();
            fecha = $('#fecha').val();
            hora = $('#hora').val();
            id_mascota = $('#id_mascota').val();
            id_veterinario = $('#id_veterinario').val();

            var formData = {
                id_cita: id_cita,
                fecha: fecha,
                hora: hora,
                id_mascota: id_mascota,
                id_veterinario: id_veterinario
            };
            $.ajax({
                type: 'POST',
                url: './views/citas/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#fecha').val('');
                    $('#hora').val('');
                    $('#id_mascota').val('');
                    $('#id_veterinario').val('');
                    $("#DataPanelCitas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Delete
$(document).ready(function() {
            $('.BtnDelCita').click(function() {
                let id_cita = $(this).attr('id_cita');

                Swal.fire({
                    title: '¿Desea eliminar la cita?',
                    text: "¡Esta acción no se puede deshacer!",
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
                            url: './views/citas/del.php',
                            data: { id_cita: id_cita },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'La cita ha sido eliminada.',
                                    'success'
                                );
                                $("#DataPanelCitas").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar la cita',
                                    'error'
                                );
                            }
                        });
                    } else {
                        Swal.fire(
                            'Cancelado',
                            'El proceso ha sido cancelado.',
                            'error'
                        );
                    }
                });

                return false;
            });
        });

    });
</script>