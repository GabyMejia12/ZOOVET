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
?>
<div id="DataPanelPreCompra"></div>
<div class="card border-info text-white mb-12"  id="DataPanelCompras">
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
            <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                <thead style="vertical-align: middle; text-align: center;">
                    <tr>
                        <th>N°</th>
                        <th>Productos</th>
                        <th>Precio <br>Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th><i class="fa-solid fa-trash-can"></i></th>
                    </tr>
                </thead>
                <tbody style="vertical-align: middle; text-align: center;">
                    <?php foreach ($detallesVentas as $data) : ?>
                        <?php
                        $id_producto = $data['id_producto'];
                        $dataProducto = "SELECT * FROM productos WHERE id_producto='$id_producto'";
                        $resultProd = $conn->query($dataProducto);
                        $rowProd = $resultProd->fetch_assoc();
                        $nproducto = $rowProd['nombre_producto'];
                        $pventa = $rowProd['pventa'];
                        ?>
                        <tr>
                            <td><?php echo ++$contProdDV; ?></td>
                            <td><?php echo $nproducto; ?></td>
                            <td>$<?php echo number_format($pventa,2); ?></td>
                            <td>
                                <?php
                                echo $data['cantidad'];
                                $contTproductos += $data['cantidad'];
                                ?>
                            </td>
                            <td>
                                $<?php
                                    echo number_format($data['total'],2);
                                    $contTotalProductos += $data['total'];
                                ?>
                            </td>
                            <td>
                                <a href="" class="btn text-white BtnDelProductoCarrito" iddventa="<?php echo $data['iddventa']; ?>" style="background-color: #031A58;"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo $contTproductos; ?></td>
                        <td>$<?php echo number_format($contTotalProductos,2);?></td>
                    </tr>
                </tbody>
            </table>
            <a href="" class="btn BtnCerrarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" id_entrada="<?php echo $data['id_entrada']; ?>"><b><i class="fa-solid fa-clipboard-check"></i></b></a>
        <?php else : ?>
            <br>
            <a href="" class="btn BtnEliminarVenta" style="background-color: #031A58;color:white;margin-top: 10px;" id_entrada="<?php echo $id_entrada; ?>"><b><i class="fa-solid fa-eraser"></i></b></a>
            <div class="alert alert-danger">
                <b>No se encuentran productos agregados al carrito</b>
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
                            <input type="number" class="form-control" style="width: 80px;" name="cantidad_detentrada" id="cantidad_detentrada" >
                        </td>
                        <td>
                            <input type="number" class="form-control" style="width: 80px;" name="cantidd_medida" id="cantidd_medida" >
                        </td>
                        <td>
                            Aqui va el total

                        </td>
                        <td>
                            $<input type="float" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="precio_compra" id="precio_compra">
                        </td>
                        <td>
                        <input type="date" class="form-control" placeholder="" name="vencimiento" id="vencimiento">
                        </td>
                        <td>
                            <a href="" class="btn text-white BtnAddProducto" id_producto="<?php echo $data['id_producto']; ?>" id_entrada="<?php echo $id_entrada; ?>" style="background-color: #031A58;"><i class="fa-solid fa-cart-plus"></i></a>
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