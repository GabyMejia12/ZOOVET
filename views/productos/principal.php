<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
include '../modal_productos.php';
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
                        <h2 class="ml-lg-2">Productos</h2>
                    </div>
                    
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewProducto">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Nuevo Producto</span>
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
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    $query = "SELECT COUNT(id_producto) as contId FROM detalle_salida WHERE id_producto='" . $data['id_producto'] . "'";
                    $result2 = $conn->query($query);
                    $row2 = $result2->fetch_assoc();
                    $contIdProduct = $row2['contId'];
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td>$<?php echo $data['precio']; ?></td>
                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Disponible</b>' : '<b style="color:red;">No Disponible</b>'; ?></td>
                        <td>
                            <a href="" class="btn text-white BtnDetalleProd" id_producto="<?php echo $data['id_producto']; ?>" style="background-color: #00008B;"><i class="fa-solid fa-list-check"></i></a>
                        </td>
                        <td>
                            <a href="" class="btn text-white BtnUpdateProduct" id_producto="<?php echo $data['id_producto']; ?>" style="background-color: #078E10;"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                        <td>
                            <?php if ($data['estado'] == 1) : ?>
                                <!-- Botón con estado 1 (activo) -->
                                <a href="" class="btn text-white BtnUpdateEstado" style="background-color: #ff6666;" id_producto="<?= $data['id_producto']; ?>" estado="1"><i class="fa-solid fa-ban"></i></a>
                            <?php else : ?>
                                <!-- Botón con estado 0 (inactivo) -->
                                <a href="" class="btn text-white BtnUpdateEstado" style="background-color: #003366;" id_producto="<?= $data['id_producto']; ?>" estado="0"><i class="fa-solid fa-check"></i></a>
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
            <b>No existen productos registrados</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        //
        $("#BtnNewProducto").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Producto';
            $("#DataModalPrincipal").load("./views/productos/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });
        


        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#nombre_producto').val() === '' || $('#descripcion').val() === '' || $('#cantidad').val() === '' || $('#precio').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let nombre_producto, descripcion, cantidad, precio, estado, tipo;
            nombre_producto = $('#nombre_producto').val();
            descripcion = $('#descripcion').val();
            cantidad = $('#cantidad').val();
            precio = $('#precio').val();
            estado = $('#estado').val();
            tipo = $('#tipo').val();

            var formData = {

                nombre_producto: nombre_producto,
                descripcion: descripcion,
                cantidad: cantidad,
                precio: precio,
                estado: estado,
                tipo: tipo
            };
            $.ajax({
                type: 'POST',
                url: './views/productos/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#nombre_producto').val('');
                    $('#descripcion').val('');
                    $('#cantidad').val('');
                    $('#precio').val('');
                    $('#estado').val('');
                    $('#tipo').val('');
                    $("#DataPanelProductos").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        
        /*Boton para ver detalle del producto
        $(".BtnDetalleProd").click(function() {
            let id_producto = $(this).attr("id_producto");
            $("#ModalPrincipalProd").modal("show");
            $('#DataEfectosModalProd').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModalProd").innerHTML = 'Detalles de Producto';
            $("#DataModalPrincipalProd").load("./views/productos/detalles.php?id_producto=" + id_producto);
            $('#ProcesoBotonModalProd').css('display', 'none');
            $('#ProcesoBotonModalProd2').css('display', 'none');
            document.getElementById("TituloBotonModalProd3").innerHTML = 'Cerrar';
            return false;
        });*/
        //Boton actualizar
        $(".BtnDetalleProd").click(function() {
            let id_producto = $(this).attr("id_producto");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl');
            document.getElementById("DataTituloModal").innerHTML = 'Detalle del producto';
            $("#DataModalPrincipal").load("./views/productos/detalles.php?id_producto=" + id_producto);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal2").innerHTML = 'cerrar';
            return false;
        });

        //Boton actualizar
        $(".BtnUpdateProduct").click(function() {
            let id_producto = $(this).attr("id_producto");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de producto';
            $("#DataModalPrincipal").load("./views/productos/form_update.php?id_producto=" + id_producto);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Update
$("#ProcesoBotonModal2").click(function() {
    if ($('#nombre_producto').val() === '' || $('#descripcion').val() === '' || $('#cantidad').val() === ''  || $('#precio').val() === '' ) {
        //alert('Por favor completa todos los campos.');
        return;
    }
    let id_producto, nombre_producto, descripcion, cantidad, precio, estado, tipo;
    id_producto = $('#id_producto').val();
    nombre_producto = $('#nombre_producto').val();
    descripcion = $('#descripcion').val();
    cantidad = $('#cantidad').val();
    precio = $('#precio').val();
   
    var formData = {
        id_producto: id_producto,
        nombre_producto: nombre_producto,
        descripcion: descripcion,
        cantidad: cantidad,
        precio: precio
    };
    $.ajax({
        type: 'POST',
        url: './views/productos/update.php',
        data: formData,
        dataType: 'html',
        success: function(response) {
            $("#ModalPrincipal").modal("hide");
            $('#nombre_producto').val('');
            $('#descripcion').val('');
            $('#cantidad').val('');
            $('#precio').val('');
            $("#DataPanelProductos").html(response);
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        }
    });
    return false;
});
// Proceso cambiar estado
$(document).ready(function() {
    $('.BtnUpdateEstado').click(function() {
        let id_producto = $(this).attr('id_producto');
        let estado = $(this).attr('estado'); 

        
        let titulo, texto;
        if (estado == '1') { 
            titulo = '¿Desea inhabilitar el producto?';
            texto = "¡Esta acción no se puede deshacer!";
            
        } else {
            titulo = '¿Desea habilitar el producto?';
            texto = "¡Esta acción no se puede deshacer!";
        }

        Swal.fire({
            title: titulo, // Título dinámico
            text: texto,   // Texto dinámico
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
                    url: './views/productos/cambiarestado.php',
                    data: { id_producto: id_producto, estado: estado },
                    
                    success: function(response) {
                        Swal.fire(
                            'Actualizado',
                            'El estado ha sido actualizado.',
                            'success'
                        );
                        $("#DataPanelProductos").html(response);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al cambiar estado',
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