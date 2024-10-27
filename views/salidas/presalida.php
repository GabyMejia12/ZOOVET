<?php

use function PHPSTORM_META\sql_injection_subst;

@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$entradaEstado0 = "SELECT salida.*, tipo_salida.nombre_salida 
                   FROM salida 
                   INNER JOIN tipo_salida ON salida.id_tiposalida = tipo_salida.id_tiposalida
                   WHERE salida.estado = 0 AND salida.id_usuario = '$id_usuario'";
$result = $conn->query($entradaEstado0);
$row = $result->fetch_assoc();

$id_salida = $row['id_salida'];
$fecha_salida = $row['fecha_salida'];
//$hora = $row['hora'];
$nombre_salida = $row['nombre_salida']; // Aquí obtienes el nombre de la salida



$sql = "SELECT * FROM productos WHERE stock > 0 AND estado = 1";
$dataProductos = $conn->query($sql);

$sqlDV = "SELECT * FROM detalle_salida WHERE id_salida='$id_salida' AND estado = 1";
$detallesVentas = $conn->query($sqlDV);

$contProd = 0;
$contProdDV = 0;
$contTproductos = 0;
$contTotalProductos = 0;
$sumaTotal = 0;
?>
<div id="DataPanelPreSalida">
    <div class="card border-info text-white mb-12"  id="DataPanelPreSalida">
        <div class="card-header bg-info border-info">
            Registrar productos                                  
        </div>
        <div class="card-body text-dark">
            <h4>Información de salida</h4>
            <hr>
                <i class="fa-solid fa-clipboard-check"></i> : <b>Finalizar salida</b> | <i class="fa-solid fa-eraser"></i> : <b>Eliminar Salida</b>
                <hr>
                <ul style="list-style-type: none; padding: 0;">
                <li><b>Fecha: <?php echo $fecha_salida; ?></b></li>
                 
                <li><b>Tipo salida: <?php echo $nombre_salida; ?></b></li>              
                </ul>  
                <?php if ($detallesVentas && $detallesVentas->num_rows > 0) : ?>
            <hr>
            <table class="table table-bordered table-hover table-borderless">
                <thead style="vertical-align: middle; text-align: center;">
                    <tr>
                        <th>N°</th>
                        <th>Productos</th>
                        <th>Cantidad <br>Vendida</th>
                        <th>Medida</th>
                        <th>Precio <br>Final</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody style="vertical-align: middle; text-align: center;">
                    <?php 
                    $contProdDV = 0; // Contador para la numeración de productos
                    $totalGeneral = 0; // Para hacer la suma de todos los productos

                    foreach ($detallesVentas as $data) : 
                        $id_producto = $data['id_producto'];
                        $cantidad_detsalida = $data['cantidad_detsalida'];
                        $precio_salida = $data['precio_salida'];
                        
                        // Obtiene los datos del producto
                        $dataProducto = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
                        $resultProd = $conn->query($dataProducto);
                        
                        if ($resultProd && $rowProd = $resultProd->fetch_assoc()) {
                            $nproducto = $rowProd['nombre_producto'];
                            $cantidad_detsalida = $data['cantidad_detsalida'];
                            $nmedida = $rowProd['medida'];                            
                            $precio_salida = $data['precio_salida'];                            
                             // Calcula el total para este producto
                            $totalGeneral += $precio_salida; // Suma al total general
                            ?>
                            <tr>
                                <td><?php echo ++$contProdDV; ?></td>
                                <td><?php echo $nproducto; ?></td>                            
                                <td><?php echo $cantidad_detsalida; ?></td>                        
                                <td><?php echo $nmedida; ?></td>  
                                <td>$ <?php echo $precio_salida; ?></td>
                                <td>
                                    <a href="" class="btn text-white BtnDelProductoCarrito" id_detsalida="<?php echo $data['id_detsalida']; ?>" style="background-color: #031A58;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                        }
                    endforeach; ?>
                    <tr>
                        <td colspan="4">Total General</td>
                        <td>$ <?php echo $totalGeneral; ?></td> <!-- Muestra el total general -->
                    </tr>
                </tbody>
            </table>
            <a href="" class="btn BtnCerrarSalida" style="background-color: #031A58;color:white;margin-top: 10px;" id_salida="<?php echo $data['id_salida']; ?>"><b><i class="fa-solid fa-clipboard-check"></i></b></a>
            <?php else : ?>
            <br>
            <a href="" class="btn BtnEliminarSalida" style="background-color: #031A58;color:white;margin-top: 10px;" id_salida="<?php echo $id_salida; ?>"><b><i class="fa-solid fa-eraser"></i></b></a>
            <div class="alert alert-danger">
                <b>No se encuentran productos agregados a la compra</b>
            </div>
            <?php endif; ?>
            <br><hr>
            <!--Cuadro que me permite agregar los productos que desee al alquiler-->
            <p style="text-align: center;"><b>Productos Disponibles</b></p>
            <hr>
            <div>
                <?php if ($dataProductos && $dataProductos->num_rows > 0) : ?>
                    <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                        <thead style="vertical-align: middle; text-align: center;">
                            <tr>
                                <th>N°</th>
                                <th>Código producto</th>
                                <th>Producto</th>
                                <th>Medida</th>                    
                                <th>Cantidad<br>Disponible</th> 
                                <th>Cantidad<br>Vendida</th>                             
                                <th>Precio <br>Venta</th>                                
                                <th>Agregar</i></th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle; text-align: center;">
                            <?php foreach ($dataProductos as $data) : ?>
                            <tr>
                                <td><?php echo ++$contProd; ?></td>
                                <td><?php echo $data['codigo_producto']; ?></td>
                                <td><?php echo $data['nombre_producto']; ?></td>
                                <td><?php echo $data['medida']; ?></td>
                                <td><?php echo $data['stock']; ?></td>
                                <td>
                                    <input type="number" name="cantidad_detsalida" id="cantidad_detsalida_<?php echo $data['id_producto']; ?>" class="form-control" style="width: 80px;">
                                </td> 
                                <td>
                                    <input type="text" class="form-control" name="precio_salida" id="precio_salida_<?php echo $data['id_producto']; ?>">
                                </td>
                                
                                <td>
                                    <a href="" class="btn text-white BtnAddProducto" id_producto="<?php echo $data['id_producto']; ?>" id_salida="<?php echo $id_salida; ?>" style="background-color: #031A58;"><i class="material-icons">add_shopping_cart</i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <b>No se encuentran productos</b>
                        </div>
                    <?php endif ?>
                    <?php cerrar_db(); ?>
                </div>
        </div>
    </div>
</div>

<script> 

        
    $(document).ready(function() {
    
    // Proceso ADD producto ya funciona
    $('.BtnAddProducto').click(function() {
    let id_producto = $(this).attr('id_producto');
    let id_salida = $(this).attr('id_salida');
    // Cambios aquí para obtener los valores correctos según el id_producto
    let cantidad_detsalida = $("#cantidad_detsalida_" + id_producto).val(); // ID del campo de cantidad_detsalida    
    let precio_salida = $("#precio_salida_" + id_producto).val(); // ID del campo de precio_compra
    

    // Ver datos que esta mandando en el console
    console.log("ID Producto: ", id_producto);
    console.log("Cantidad Det. Entrada: ", cantidad_detsalida);    
    console.log("Precio Compra: ", precio_salida);    
    console.log("ID Entrada: ", id_salida);

    Swal.fire({
        title: '¿Desea agregar producto a la venta?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            if (cantidad_detsalida == 0 || cantidad_detsalida == null ||                
                precio_salida == 0 || precio_salida == null ) {
                Swal.fire('Error', 'Favor llenar los campos', 'error');
            } else {
                $.ajax({
                    type: 'POST',
                    url: './views/salidas/regdetallesalida.php',
                    data: {
                        id_producto: id_producto,
                        cantidad_detsalida: cantidad_detsalida,                        
                        precio_salida: precio_salida,                        
                        id_salida: id_salida
                    },
                    success: function(response) {
                        $("#DataPanelPreSalida").html(response);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', xhr.responseText, 'error');
                    }
                });
            }
        } else {
            Swal.fire('Cancelado', 'Proceso cancelado', 'error');
        }
    });
    return false;
});


        // Proceso borrar producto del carrito ya funciona
        $('.BtnDelProductoCarrito').click(function() {
            
            let id_detsalida = $(this).attr('id_detsalida');
            Swal.fire({
                title: '¿Desea eliminar producto de la compra?',
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
                        url: './views/salidas/delcarritosalida.php',
                        data: {
                            id_detsalida: id_detsalida
                        },
                        success: function(response) {
                            $("#DataPanelPreSalida").html(response);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', xhr.responseText, 'error');
                        }
                    });
                } else {
                    Swal.fire('Cancelado', 'Proceso cancelado', 'error');
                }
            });
            return false;
        });

        // Proceso Cerrar venta funciona bien
        $('.BtnCerrarSalida').click(function() {
            
            let id_salida = $(this).attr('id_salida');

            Swal.fire({
                title: '¿Desea finalizar el registro de venta?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: './views/salidas/cerrarsalida.php',
                        data: {
                            id_salida: id_salida
                        },
                        success: function(response) {
                            $("#DataPanelPreSalida").html(response);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', xhr.responseText, 'error');
                        }
                    });
                } else {
                    Swal.fire('Cancelado', 'Proceso cancelado', 'error');
                }
            });
            return false;
        });

        // Proceso Eliminar venta 
        $('.BtnEliminarSalida').click(function() {
        //let idalquiler = $(this).attr('idalquiler');
        let id_salida = $(this).attr('id_salida');

        Swal.fire({
            title: '¿Desea eliminar el registro de venta?',
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
                    url: './views/salidas/delsalida.php',
                    data: {
                        id_salida: id_salida
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Eliminado', response.message, 'success').then(() => {
                                $("#sub-data").load("./views/salidas/principal.php");
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al eliminar el registro de compra', 'error');
                    }
                });
            } else {
                Swal.fire('Cancelado', 'Proceso cancelado', 'error');
            }
        });
        return false;
    });
    });
</script>