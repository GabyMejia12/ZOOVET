<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT a.*, b.usuario FROM veterinario a inner join usuarios b on a.id_usuario=b.id_usuario";


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
                        <h2 class="ml-lg-2">Médicos Veterinarios</h2>
                    </div>
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewVet">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Médico Veterinario</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelMedicos">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(id_veterinario) as contId FROM veterinario WHERE id_veterinario='" . $data['id_veterinario'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['codigo_veterinario']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['apellido']; ?></td>
                        <td><?php echo $data['usuario']; ?></td>
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateMed" id_veterinario="<?php echo $data['id_veterinario']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
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
                            <?php if ($contIdUser == 1) : ?>
                                <a href="" class="btn text-white BtnDeleteVet" id_veterinario="<?php echo $data['id_veterinario']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-user-xmark"></i></a>
                            <?php else : ?>
                                <a href="" class="btn text-white" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-solid fa-user-xmark"></i></a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        
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
        $("#BtnNewVet").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Veterinario';
            $("#DataModalPrincipal").load("./views/medicos/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });


        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#codigo_veterinario').val() === '' || $('#nombre').val() === '' || $('#apellido').val() === '' || $('#id_usuario').val() === '') {
                alert('Por favor completa todos los campos.');
                return;
            }
            let codigo_veterinario, nombre, apellido,id_usuario;
            codigo_veterinario = $('#codigo_veterinario').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            id_usuario = $('#id_usuario').val();

            var formData = {

                codigo_veterinario: codigo_veterinario,
                nombre: nombre,
                apellido: apellido,
                id_usuario: id_usuario
            };
            $.ajax({
                type: 'POST',
                url: './views/medicos/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#codigo_veterinario').val('');
                    $('#nombre').val('');
                    $('#apellido').val('');
                    $('#id_usuario').val('');
                    $("#DataPanelMedicos").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
            
        });
        //Boton actualizar
        $(".BtnUpdateMed").click(function() {
                console.log('clic en el boton');
                let id_veterinario = $(this).attr("id_veterinario");
                $("#ModalPrincipal").modal("show");
                $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
                document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de médicos';
                $("#DataModalPrincipal").load("./views/medicos/form_update.php?id_veterinario=" + id_veterinario);
                $('#ProcesoBotonModal').css('display', 'none');
                $('#ProcesoBotonModal2').css('display', 'block');
                document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
                return false;
            });
        
        });

        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#nombre').val() === '' || $('#apellido').val() === '' ) {
                //alert('Por favor completa todos los campos.');
                return;
            }
            let id_veterinario, nombre, apellido;
            id_veterinario = $('#id_veterinario').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            

            var formData = {
                id_veterinario: id_veterinario,
                nombre: nombre,
                apellido: apellido,
                
            };
            $.ajax({
                type: 'POST',
                url: './views/medicos/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#nombre').val('');
                    $('#apellido').val('');
                    $("#DataPanelMedicos").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Delete
        $(document).ready(function() {
                $('.BtnDeleteVet').click(function() {
                    let id_veterinario = $(this).attr('id_veterinario');

                    Swal.fire({
                        title: '¿Desea eliminar el veterinario?',
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
                                url: './views/medicos/del.php',
                                data: { id_veterinario: id_veterinario },
                                success: function(response) {
                                    Swal.fire(
                                        'Eliminado',
                                        'El veterinario ha sido eliminada.',
                                        'success'
                                    );
                                    $("#DataPanelMedicos").html(response);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error',
                                        'Hubo un problema al eliminar el registro',
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


  
</script>