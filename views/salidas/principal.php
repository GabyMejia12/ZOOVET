<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
include '../modal_productos.php';
$conn = conectar_db();



$sql = "SELECT a.estado, a.id_salida, a.fecha_salida, b.nombre_producto, b.descripcion, c.cantidad_detsalida,  c.precio_salida, b.medida,d.nombre_salida 
FROM salida a 
INNER JOIN tipo_salida d
ON a.id_tiposalida = d.id_tiposalida
INNER JOIN detalle_salida c
 ON a.id_salida = c.id_salida
INNER JOIN productos b  
ON c.id_producto = b.id_producto 
WHERE a.estado = 1
ORDER BY a.id_salida, b.nombre_producto";

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
                        <h2 class="ml-lg-2">Salidas</h2>
                    </div>
                    
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="panel-presalidas">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Nueva Salida</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive" id="DataPnaelSalidas">
                    <?php if ($result && $result->num_rows > 0) : ?>
                        <?php 
                        $dataArray = []; // Crear un array para almacenar los resultados
                        
                        // Convertir el resultado en un array
                        while ($row = $result->fetch_assoc()) {
                            $dataArray[] = $row;
                        }
                        ?>
                        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%;">
                            <thead style="vertical-align: middle; text-align: center;">
                                <tr>
                                    <th>Identificación <br> entrada</th>
                                    <th>Producto</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Medida</th>
                                    <th>Precio <br> Venta</th>
                                    <th>Movimiento</th>
                                    <th>Estado <br>Venta</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle; text-align: center;">
                                <?php 
                                $entrada_actual = null;
                                $producto_count = []; // Contador de productos por entrada
                                $cont = 0; // Contador para las entradas

                                // Contar cuántos productos hay por cada entrada
                                foreach ($dataArray as $data) {
                                    if (!isset($producto_count[$data['id_salida']])) {
                                        $producto_count[$data['id_salida']] = 0;
                                    }
                                    $producto_count[$data['id_salida']]++;
                                }

                                // Recorremos los datos para mostrarlos
                                foreach ($dataArray as $index => $data) : 
                                    // Si la entrada cambia, mostramos una nueva fila de encabezado
                                    if ($entrada_actual != $data['id_salida']) {
                                        $entrada_actual = $data['id_salida'];
                                    ?>
                                        <tr>
                                            <td rowspan="<?php echo $producto_count[$entrada_actual]; ?>"><?php echo ++$cont; ?></td>                            
                                            <td><?php echo $data['nombre_producto']; ?></td>
                                            <td><?php echo $data['descripcion']; ?></td>
                                            <td><?php echo $data['cantidad_detsalida']; ?></td>
                                            <td><?php echo $data['medida']; ?></td>
                                            <td>$<?php echo $data['precio_salida']; ?></td>
                                            <td><?php echo $data['nombre_salida']; ?></td>
                                            <td rowspan="<?php echo $producto_count[$entrada_actual]; ?>">
                                                <?php echo ($data['estado'] == 1) ? '<b style="color:green;">Finalizada</b>' : '<b style="color:red;">Abierta</b>'; ?>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td><?php echo $data['nombre_producto']; ?></td>
                                            <td><?php echo $data['descripcion']; ?></td>
                                            <td><?php echo $data['cantidad_detsalida']; ?></td>
                                            <td><?php echo $data['medida']; ?></td>
                                            <td>$<?php echo $data['precio_salida']; ?></td>
                                            <td><?php echo $data['nombre_salida']; ?></td>
                                        </tr>
                                    <?php } 

                                    // Línea de separación después del último producto de cada entrada
                                    if (($index + 1 < count($dataArray) && $dataArray[$index + 1]['id_salida'] != $data['id_salida']) || ($index + 1 == count($dataArray))) {
                                        echo '<tr><td colspan="8" style="border-bottom: 2px solid #ccc;"></td></tr>'; // Línea de separación
                                    }
                                endforeach; ?>
                            </tbody>
                        </table>

                        <div class="clearfix">
                            <div class="hint-text">Mostrando <b><?php echo $cont; ?></b> de <b><?php echo $cont; ?></b></div>
                            <ul class="pagination">
                                <li class="page-item disabled"><a href="#">Anterior</a></li>
                                <li class="page-item"><a href="#" class="page-link">1</a></li>
                                <li class="page-item active"><a href="#" class="page-link">2</a></li>
                                <li class="page-item"><a href="#" class="page-link">3</a></li>
                                <li class="page-item"><a href="#" class="page-link">Siguiente</a></li>
                            </ul>
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
        $("#panel-presalidas").click(function() {
            $("#sub-data").load("./views/salidas/nueva_salida.php");
            return false;
        });
    });
</script>