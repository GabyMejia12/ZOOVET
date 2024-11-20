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
                        <h2 class="ml-lg-2">Inventario</h2>
                    </div>
                    
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="panel-inventario-detalle">
                            <i class="material-icons">insert_chart</i> <span>Reporte General</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelProductos">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Código <br>Producto</th>
                    <th>Nombre <br>Producto</th>
                    <th>Fecha <br> Vencimiento</th> 
                    <th>Unidad <br>Presentación</th>                   
                    <th>Precio de <br> Compra</th>                                                          
                    <th>Total <br>Comprado</th>
                    <th>Total <br>Vendido</th> 
                    <th>Existencias</th>                  
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    <?php
                    // Calcular total de entradas
                    $queryEntradas = "SELECT SUM(b.total) AS totalEntrada, b.vencimiento, b.precio_compra, SUM(b.cantidad_detentrada) AS totalEtradaPresentacion
                                      FROM entrada a
                                      INNER JOIN detalle_entrada b ON a.id_entrada = b.id_entrada
                                      WHERE b.id_producto = '" . $data['id_producto'] . "'";
                    $resultEntradas = $conn->query($queryEntradas);
                    $rowEntradas = $resultEntradas->fetch_assoc();
                    $sumaEntradas = $rowEntradas['totalEntrada'] ? $rowEntradas['totalEntrada'] : 0;
                    $vencimiento = $rowEntradas['vencimiento'];
                    $precio_compra = $rowEntradas['precio_compra'];
                    //$cantidad_detentrada = $rowEntradas['totalEtradaPresentacion'];
                    

                    // Calcular total de salidas
                    $querySalidas = "SELECT SUM(cantidad_detsalida) AS totalSalida 
                                     FROM detalle_salida 
                                     WHERE id_producto = '" . $data['id_producto'] . "'";
                    $resultSalidas = $conn->query($querySalidas);
                    $rowSalidas = $resultSalidas->fetch_assoc();
                    $sumaSalidas = $rowSalidas['totalSalida'] ? $rowSalidas['totalSalida'] : 0;
                    ?>
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['codigo_producto']; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>  
                        <td><?php echo $vencimiento ?></td>                       
                        <td><?php echo $data['medida']; ?></td>
                        <td>$<?php echo $precio_compra ; ?></td>                        
                        <td><?php echo $sumaEntradas; ?></td>
                        <td><?php echo $sumaSalidas; ?></td>
                        <td><?php echo $data['stock']; ?></td>
                                        
                        <td>
                            <a href="" class="btn text-white BtnDetllaeInventario" id_producto="<?php echo $data['id_producto']; ?>" style="background-color: #00008B;"><i class="fa-solid fa-square-poll-vertical"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        
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
        $("#panel-inventario-detalle").click(function() {
            $("#sub-data").load("./views/inventario/detalle_inventario.php");
            return false;
        });

        // Manejo del botón de detalle por producto
        $(".BtnDetllaeInventario").click(function() {
            var id_producto = $(this).attr("id_producto");
            console.log("id producto: ", id_producto); // Verifica el id_producto

            if (!id_producto) {
                console.error("El ID del producto no está definido.");
                return; // Salir si no hay id_producto
            }

            // Cargar el detalle del producto
            $("#sub-data").load("./views/inventario/detalleinventario_producto.php?id_producto=" + id_producto, function(response, status, xhr) {
                if (status == "error") {
                    console.error("Error al cargar el detalle del producto:", xhr.status, xhr.statusText);
                    alert("Error al cargar el detalle del producto.");
                }
            });
            return false;
        });

    });
</script>

