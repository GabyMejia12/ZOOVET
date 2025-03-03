<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT * FROM propietario";

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
                        <h2 class="ml-lg-2">Propietarios</h2>
                    </div>
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewProp">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Nuevo Propietario</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelPropietarios">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(id_propietario) as contId FROM propietario WHERE id_propietario='" . $data['id_propietario'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['apellido']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['direccion']; ?></td>
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateUser" id_propietario="<?php echo $data['id_propietario']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
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
                                <a href="" class="btn text-white BtnDeleteUser" id_propietario="<?php echo $data['id_propietario']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-user-xmark"></i></a>
                                
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
        $("#BtnNewProp").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Propietario';
            $("#DataModalPrincipal").load("./views/propietarios/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });


        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#nombre').val() === '' || $('#apellido').val() === '' || $('#telefono').val() === '' || $('#direccion').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let nombre, apellido, telefono, direccion;
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            telefono = $('#telefono').val();
            direccion = $('#direccion').val();

            var formData = {

                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/propietarios/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#nombre').val('');
                    $('#apellido').val('');
                    $('#telefono').val('');
                    $('#direccion').val('');
                    $("#DataPanelPropietarios").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        //Boton actualizar
        $(".BtnUpdateUser").click(function() {
            let id_propietario = $(this).attr("id_propietario");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de propietario';
            $("#DataModalPrincipal").load("./views/propietarios/form_update.php?id_propietario=" + id_propietario);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#nombre').val() === '' || $('#apellido').val() === '' || $('#telefono').val() === '' || $('#direccion').val() ==="" ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let id_propietario, nombre, apellido, telefono, estado, direccion;
            id_propietario = $('#id_propietario').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            telefono = $('#telefono').val();            
            direccion = $('#direccion').val();

            var formData = {
                id_propietario: id_propietario,
                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                
                direccion: direccion
            };
            $.ajax({
                type: 'POST',
                url: './views/propietarios/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#usuario').val('');
                    $('#apellido').val('');
                    $('#telefono').val('');
                    $('#direccion').val('');
                    $("#DataPanelPropietarios").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });// Proceso Delete
$(document).ready(function() {
            $('.BtnDeleteUser').click(function() {
                let id_propietario = $(this).attr('id_propietario');

                Swal.fire({
                    title: '¿Desea eliminar el propietario?',
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
                            url: './views/propietarios/del.php',
                            data: { id_propietario: id_propietario },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El propietario ha sido eliminado',
                                    'success'
                                );
                                $("#DataPanelPropietarios").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar el propietario',
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