<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$entradaEstado0 = "SELECT * FROM entrada WHERE estado=0 AND id_usuario='$id_usuario'";
$result = $conn->query($entradaEstado0);
$row = $result->fetch_assoc();
$id_entrada = $row['id_entrada'];
$fecha = $row['fecha'];
$hora = $row['hora'];


$sql = "SELECT * FROM productos WHERE stock >= 0 AND estado = 1";
$dataProductos = $conn->query($sql);

$sqlDV = "SELECT * FROM detalle_entrada WHERE id_entrada='$id_entrada' AND estado = 0";
$detallesVentas = $conn->query($sqlDV);

$contProd = 0;
$contProdDV = 0;
$contTproductos = 0;
$contTotalProductos = 0;
$sumaTotal = 0;
?>
<div id="DataPanelPreCompra"></div>
<div class="card border-info text-white mb-12"  id="DataPanelCompra">
    <div class="card-header bg-info border-info">
        Registrar productos   
                               
    </div>
    <div class="card-body text-dark">
        <h4>Información de compra</h4>
        <hr>
        <i class="fa-solid fa-clipboard-check"></i> : <b>Finalizar compra</b> | <i class="fa-solid fa-eraser"></i> : <b>Eliminar Compra</b>
        <hr>
        <ul style="list-style-type: none; padding: 0;">
        <li><b>Fecha: <?php echo $fecha; ?></b></li>
        <li><b>Hora: <?php echo $hora; ?></b></li>        
        </ul>  
        
        <?php if ($detallesVentas && $detallesVentas->num_rows > 0) : ?>
            <hr>
            <table class="table table-bordered table-hover table-borderless">
                <thead style="vertical-align: middle; text-align: center;">
                    <tr>
                        <th>N°</th>
                        <th>Productos</th>
                        <th>Cantidad <br>Individual</th>
                        <th>Cantidad <br>Medida</th>
                        <th>Total</th>
                        <th>Medida</th>
                        <th>Precio <br>Individual</th>
                        <th>Precio <br>Total</th>
                        <th><i class="fa-solid fa-trash-can"></i></th>
                    </tr>
                </thead>
                <tbody style="vertical-align: middle; text-align: center;">
                    <?php foreach ($detallesVentas as $data) : ?>
                        <?php
                        $id_producto = $data['id_producto'];
                        $dataProducto = "SELECT a.*, b.* FROM productos a INNER JOIN detalle_entrada b ON b.id_producto='$id_producto'";
                        $resultProd = $conn->query($dataProducto);
                        $rowProd = $resultProd->fetch_assoc();
                        $nproducto = $rowProd['nombre_producto'];
                        $cantidad_detentrada = $rowProd['cantidad_detentrada'];
                        $cantidad_medida = $rowProd['cantidad_medida'];
                        $total = $rowProd['total'];
                        $medida = $rowProd['medida'];
                        $precio_compra = $rowProd['precio_compra'];
                        ?>
                        <tr>
                            <td><?php echo ++$contProdDV; ?></td>
                            <td><?php echo $nproducto; ?></td>                            
                            <td>
                            <?php echo $cantidad_detentrada; 
                            $contTproductos += $data['cantidad_detentrada'];?>
                            </td>
                            <td>
                            <?php echo $cantidad_medida; ?> 
                            </td>
                            <td>
                            <?php echo $total; ?> 
                            </td>
                            <td>
                            <?php echo $medida; ?> 
                            </td>
                            <td>
                            $ <?php echo $precio_compra; ?> 
                            </td>
                            <td>                                
                            $ <?php 
                            $sumaTotal = $precio_compra*$cantidad_detentrada;  echo $sumaTotal; ?> 
                            </td>
                            <td>
                                <a href="" class="btn text-white BtnDelProductoCarrito" id_detentrada="<?php echo $data['id_detentrada']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="7">Total</td>
                        <td> $ <?php echo $sumaTotal; ?></td>
                        
                    </tr>
                </tbody>
            </table>
            <a href="" class="btn BtnCerrarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" id_entrada="<?php echo $data['id_entrada']; ?>"><b><i class="fa-solid fa-clipboard-check"></i></b></a>
        <?php else : ?>
            <br>
            <a href="" class="btn BtnEliminarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" id_entrada="<?php echo $id_entrada; ?>"><b><i class="fa-solid fa-eraser"></i></b></a>
            <div class="alert alert-danger">
                <b>No se encuentran productos agregados a la compra</b>
            </div>
        <?php endif ?>
        <hr>
<!--Cuadro que me permite agregar los productos que desee al alquiler-->
<p style="text-align: center;"><b>Inventario</b></p>
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
                    <th>Cantidad <br>Entera</th>
                    <th>Cantidad <br>Medida</th>
                    <th>Total</th>
                    <th>Precio <br>Compra</th>
                    <th>Vencimiento</th>
                    <th><i class="fa-solid fa-cart-plus"></i></th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($dataProductos as $data) : ?>
                    <tr>
                        <td><?php echo ++$contProd; ?></td>
                        <td><?php echo $data['codigo_producto']; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>
                        <td><?php echo $data['medida']; ?></td>
                        <td>
                            <input type="number" name="cantidad_detentrada" id="cantidad_detentrada" class="form-control" style="width: 80px;"  >
                        </td>
                        <td>
                            <input type="number"name="cantidad_medida" id="cantidad_medida" class="form-control" style="width: 80px;"  >
                        </td>
                        <td>
                            <input type="text" class="form-control"  name="total" id="total" readonly>

                        </td>
                        <td>
                            <input type="text" class="form-control" name="precio_compra" id="precio_compra">
                        </td>
                        <td>
                        <input type="date" class="form-control" placeholder="" name="vencimiento" id="vencimiento">
                        </td>
                        <td>
                            <a href="" class="btn text-white BtnAddProducto" id_producto="<?php echo $data['id_producto']; ?>" id_entrada="<?php echo $id_entrada; ?>"  style="background-color: #031A58;"><i class="fa-solid fa-cart-plus"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
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

<script>
        
    </script>




<script>
    // Función para calcular el total
    function calcularTotal() {
            var cantidad_detentrada = parseInt(document.getElementById("cantidad_detentrada").value);
            var cantidad_medida = parseInt(document.getElementById("cantidad_medida").value);
            var total = cantidad_detentrada * cantidad_medida;
            document.getElementById("total").value = total;

            
        }
        // Escuchar los cambios en los campos
            document.getElementById("cantidad_detentrada").addEventListener("change", calcularTotal);
            document.getElementById("cantidad_medida").addEventListener("change", calcularTotal);

        
    $(document).ready(function() {
        // Proceso ADD producto ya funciona
        $('.BtnAddProducto').click(function() {
            let id_producto = $(this).attr('id_producto');
            let id_entrada = $(this).attr('id_entrada');
            let cantidad_detentrada = $("#cantidad_detentrada" ).val(); // ID del campo de cantidad_detentrada
            let cantidad_medida = $("#cantidad_medida").val(); // ID del campo de cantidad_medida
            let precio_compra = $("#precio_compra").val(); // Extraído del botón
            let total = $("#total" ).val(); // ID del campo de total
            let vencimiento = $("#vencimiento").val(); 
            
            

            // Ver datos que esta mandando en el console
            console.log("ID Producto: ", id_producto);
            console.log("Cantidad Det. Entrada: ", cantidad_detentrada);
            console.log("Cantidad Medida: ", cantidad_medida);
            console.log("Total: ", total);
            console.log("Precio Compra: ", precio_compra);
            console.log("Vencimiento: ", vencimiento);
            console.log("ID Entrada: ", id_entrada);

            Swal.fire({
                title: '¿Desea agregar producto a la compra?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (cantidad_detentrada == 0 || cantidad_detentrada == null ||
                        cantidad_medida == 0 || cantidad_medida == null || 
                        precio_compra == 0 || precio_compra == null || 
                        vencimiento == 0 || vencimiento == null) {
                        Swal.fire('Error', 'Favor llenar los campos', 'error');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: './views/compras/regdetallecompra.php',
                            data: {
                                id_producto: id_producto,
                                cantidad_detentrada: cantidad_detentrada,
                                cantidad_medida: cantidad_medida,
                                total: total,
                                precio_compra: precio_compra,
                                vencimiento: vencimiento,
                                id_entrada: id_entrada
                            },
                            success: function(response) {
                                $("#DataPanelPreCompra").html(response);
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
            
            let id_detentrada = $(this).attr('id_detentrada');
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
                        url: './views/compras/delcarritocompra.php',
                        data: {
                            id_detentrada: id_detentrada
                        },
                        success: function(response) {
                            $("#DataPanelPreCompra").html(response);
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

        // Proceso Cerrar Venta ya funciona
        $('.BtnCerrarVenta').click(function() {
            
            let idventa = $(this).attr('idventa');

            Swal.fire({
                title: '¿Desea cerrar el proceso de venta?',
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
                        url: './views/ventas/cerrar.php',
                        data: {
                            idventa: idventa
                        },
                        success: function(response) {
                            $("#DataVentas").html(response);
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

        // Proceso Eliminar venta ya funciona
        $('.BtnEliminarVenta').click(function() {
        //let idalquiler = $(this).attr('idalquiler');
        let idventa = $(this).attr('idventa');

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
                    url: './views/ventas/delventa.php',
                    data: {
                        idventa: idventa
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Eliminado', response.message, 'success').then(() => {
                                $("#sub-data").load("./views/ventas/principal.php");
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al eliminar el registro de venta', 'error');
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