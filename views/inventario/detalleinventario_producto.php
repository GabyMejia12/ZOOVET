<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Obtener el ID del producto desde la consulta
$id_producto = $_GET['id_producto'];
$cont = 0;
$total_precio_compra = 0;
$total_precio_venta = 0;
$total_cantidad_comprada = 0;
$total_cantidad_vendida = 0;
// Realizar la consulta para obtener los detalles del producto
$sql = "SELECT * FROM productos WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar un arreglo para almacenar el producto
$producto = [];

// Verificar si se encontró el producto
if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
}

// Cerrar la conexión a la base de datos
cerrar_db();
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
        <div class="col-md-12" style="margin-bottom: 5px;">
            <!-- Incluye Bootstrap JS -->
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Detalle de inventario</h2>
                        </div>
                        <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                            <a href="#" class="btn btn-success" id="panel-inventario-detalle">
                                <i class="material-icons">description</i>
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
                                    <th>Fecha <br>Movimiento</th>
                                    <th>Tipo de Movimiento</th>
                                    <th>Código <br> Producto</th>
                                    <th>Nombre <br>Producto</th>
                                    <th>Fecha <br> Vencimiento</th>
                                    <th>Unidad <br> Medida</th>
                                    <th>Precio de <br> Compra</th>
                                    <th>Precio de <br> Venta</th>
                                    <th>Cantidad <br> Comprada</th>
                                    <th>Cantidad <br> Vendida</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle; text-align: center;">
                                <?php foreach ($result as $data) : ?>
                                    <?php
                                    // Consultar movimientos de entrada
                                    $queryMovimientosEntrada = "SELECT a.fecha AS fecha_movimiento, b.total AS cantidad, b.vencimiento, b.precio_compra
                                                                FROM entrada a
                                                                INNER JOIN detalle_entrada b ON a.id_entrada = b.id_entrada
                                                                WHERE b.id_producto = '" . $data['id_producto'] . "'";

                                    
                                    $resultMovimientosEntrada = $conn->query($queryMovimientosEntrada);

                                    // Consultar movimientos de salida
                                    $queryMovimientosSalida = "SELECT a.fecha_salida AS fecha_movimiento, b.cantidad_detsalida AS cantidad, b.precio_salida
                                                               FROM salida a
                                                               INNER JOIN detalle_salida b ON a.id_salida = b.id_salida
                                                               WHERE b.id_producto = '" . $data['id_producto'] . "'";
                                    
                                    $resultMovimientosSalida = $conn->query($queryMovimientosSalida);

                                    // Combinar movimientos de entrada y salida
                                    $movimientos = [];
                                    while ($row = $resultMovimientosEntrada->fetch_assoc()) {
                                        $movimientos[] = [
                                            'tipo' => 'Entrada',
                                            'fecha_movimiento' => $row['fecha_movimiento'],
                                            'cantidad' => $row['cantidad'] ?? 0,
                                            'vencimiento' => $row['vencimiento'] ?? '-',
                                            'precio_compra' => $row['precio_compra'] ?? 0,
                                            'precio_salida' => 0,
                                            'cantidad_vendida' => 0
                                        ];
                                        $total_precio_compra += $row['precio_compra'] ?? 0;
                                        $total_cantidad_comprada += $row['cantidad'] ?? 0;
                                    }
                                    while ($row = $resultMovimientosSalida->fetch_assoc()) {
                                        $movimientos[] = [
                                            'tipo' => 'Salida',
                                            'fecha_movimiento' => $row['fecha_movimiento'],
                                            'cantidad' => 0,
                                            'vencimiento' => '-',
                                            'precio_compra' => 0,
                                            'precio_salida' => $row['precio_salida'] ?? 0,
                                            'cantidad_vendida' => $row['cantidad'] ?? 0
                                        ];
                                        $total_precio_venta += $row['precio_salida'] ?? 0;
                                        $total_cantidad_vendida += $row['cantidad'] ?? 0;
                                    }

                                    // Ordenar movimientos por fecha
                                    usort($movimientos, function ($a, $b) {
                                        return strtotime($a['fecha_movimiento']) - strtotime($b['fecha_movimiento']);
                                    });

                                    // Mostrar cada movimiento en una fila
                                    foreach ($movimientos as $movimiento) :
                                    ?>
                                        <tr>
                                            <td><?php echo ++$cont; ?></td>
                                            <td><?php echo $movimiento['fecha_movimiento'] ?? '-'; ?></td>
                                            <td style="color: <?php echo $movimiento['tipo'] === 'Salida' ? 'red' : 'green'; ?>;"><?php echo $movimiento['tipo']; ?></td>
                                            <td><?php echo $data['codigo_producto']; ?></td>
                                            <td><?php echo $data['nombre_producto']; ?></td>
                                            <td><?php echo $movimiento['vencimiento']; ?></td>
                                            <td><?php echo $data['medida']; ?></td>
                                            <td>$<?php echo number_format($movimiento['precio_compra'], 2); ?></td>
                                            <td>$<?php echo number_format($movimiento['precio_salida'], 2); ?></td>
                                            <td><?php echo $movimiento['cantidad']; ?></td>
                                            <td><?php echo $movimiento['cantidad_vendida']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" style="text-align: center;"><strong>Totales</strong></td>
                                    <td style="text-align: center;"><strong>$<?php echo number_format($total_precio_compra, 2); ?></strong></td>
                                    <td style="text-align: center;"><strong>$<?php echo number_format($total_precio_venta, 2); ?></strong></td>
                                    <td style="text-align: center;"><strong><?php echo $total_cantidad_comprada; ?></strong></td>
                                    <td style="text-align: center;"><strong><?php echo $total_cantidad_vendida; ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php else : ?>
                        <p>No hay datos disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
