<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT * FROM productos";

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
                        <h2 class="ml-lg-2">Compras</h2>
                    </div>
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewProp">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Nueva Compra</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelProductos">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 80%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(id_producto) as contId FROM propietario WHERE id_producto='" . $data['id_producto'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdUser = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>
                        <td><?php echo $data['descripcion']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td><?php echo $data['precio']; ?></td>
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateProducto" id_producto="<?php echo $data['id_producto']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
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
                                <a href="" class="btn text-white BtnDeleteUser" id_producto="<?php echo $data['id_producto']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-user-xmark"></i></a>
                                
                            <?php else : ?>
                                <a href="" class="btn text-white" style="background-color: #031A58;background-color: #ccc; cursor: not-allowed;" onclick="return false;"><i class="fa-solid fa-user-xmark"></i></a>
                            <?php endif ?>
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
        $("#BtnNewProp").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Producto';
            $("#DataModalPrincipal").load("./views/compras/form_insert.php");  
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
                    $("#DataPanelProductos").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        //Boton actualizar
        $(".BtnUpdateProducto").click(function() {
            let id_producto = $(this).attr("id_producto");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de propietario';
            $("#DataModalPrincipal").load("./views/propietarios/form_update.php?id_producto=" + id_producto);
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
            let id_producto, nombre, apellido, telefono, estado, direccion;
            id_producto = $('#id_producto').val();
            nombre = $('#nombre').val();
            apellido = $('#apellido').val();
            telefono = $('#telefono').val();            
            direccion = $('#direccion').val();

            var formData = {
                id_producto: id_producto,
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
                    $("#DataPanelProductos").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });// Proceso Delete
$(document).ready(function() {
            $('.BtnDeleteUser').click(function() {
                let id_producto = $(this).attr('id_producto');

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
                            data: { id_producto: id_producto },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'El propietario ha sido eliminado',
                                    'success'
                                );
                                $("#DataPanelProductos").html(response);
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