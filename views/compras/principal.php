<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT  a.id_entrada, a.fecha, b.nombre_producto, c.cantidad_detentrada, c.cantidad_medida, c.precio_compra, c.vencimiento 
FROM entrada a 
INNER JOIN detalle_entrada c
 ON a.id_entrada = c.id_entrada
INNER JOIN productos b  
ON  c.id_producto = b.id_producto";

$result = $conn->query($sql);
$cont = 0;
$total_compra=0;


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
                        <a href="#" class="btn btn-success" id="panel-entradas">
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
                    <th>Fecha <br>Compra</th>
                    <th>Producto</th>
                    <th>Cantidad por unidad <br> (frasco, caja, blister,etc)</th>
                    <th>Cantidad por medida <br> (ml, tabletas,etc)</th>
                    <th>Precio compra <br>detalle</th>
                    <th>Total Compra</th>
                    <th>Vencimiento</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;" style="margin: 0 auto; width: 80%">
                <?php foreach ($result as $data) : ?>
                    
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td><?php echo $data['nombre_producto']; ?></td>
                        <td><?php echo $data['cantidad_detentrada']; ?></td>
                        <td><?php echo $data['cantidad_medida']; ?></td>
                        <td><?php echo $data['precio_compra']; ?></td>
                        <td>$<?php 
                            $total_compra = $data['cantidad_detentrada'] * $data['precio_compra']; 
                            echo $total_compra; 
                        ?></td>
                        <td><?php echo $data['vencimiento']; ?></td>                    
                                             
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
            
			$("#panel-entradas").click(function() {
                $("#sub-data").load("./views/compras/nueva_compra.php");
                return false;
            }); 
        });
  </script>