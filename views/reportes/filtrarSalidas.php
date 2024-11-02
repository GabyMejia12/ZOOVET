<?php
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$cont = 0;
$total_precio_salida = 0;
$total_cantidad_vendida = 0;

if ($result && $result->num_rows > 0) {
    echo '<table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                <tr>
                    <th>N°</th>
                    <th>Fecha <br>Movimiento</th>
                    <th>Tipo de Movimiento</th>
                    <th>Código <br>Producto</th>
                    <th>Nombre <br>Producto</th>
                    <th>Unidad <br>Medida</th>
                    <th>Precio de <br>Salida</th>
                    <th>Cantidad <br>Vendida</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">';

    while ($data = $result->fetch_assoc()) {
        // Consultar movimientos de salida para cada producto
        $queryMovimientosSalida = "SELECT a.fecha_salida AS fecha_movimiento, b.cantidad_detsalida AS cantidad, b.precio_salida
                                   FROM salida a
                                   INNER JOIN detalle_salida b ON a.id_salida = b.id_salida
                                   WHERE b.id_producto = ?";
        
        if ($fechaInicio && $fechaFin) {
            $queryMovimientosSalida .= " AND a.fecha_salida BETWEEN ? AND ?";
            $stmtSalida = $conn->prepare($queryMovimientosSalida);
            $stmtSalida->bind_param("sss", $data['id_producto'], $fechaInicio, $fechaFin);
        } else {
            $stmtSalida = $conn->prepare($queryMovimientosSalida);
            $stmtSalida->bind_param("s", $data['id_producto']);
        }

        $stmtSalida->execute();
        $resultMovimientosSalida = $stmtSalida->get_result();

        while ($movimiento = $resultMovimientosSalida->fetch_assoc()) {
            $cont++;
            $total_precio_salida += $movimiento['precio_salida'];
            $total_cantidad_vendida += $movimiento['cantidad'];

            echo "<tr>
                    <td>{$cont}</td>
                    <td>{$movimiento['fecha_movimiento']}</td>
                    <td style='color: red;'>Salida</td>
                    <td>{$data['codigo_producto']}</td>
                    <td>{$data['nombre_producto']}</td>
                    <td>{$data['medida']}</td>
                    <td>$" . number_format($movimiento['precio_salida'], 2) . "</td>
                    <td>{$movimiento['cantidad']}</td>
                  </tr>";
        }

        $stmtSalida->close();
    }

    echo '</tbody>
          <tfoot>
              <tr>
                  <td colspan="6" style="text-align: center;"><strong>Totales</strong></td>
                  <td style="text-align: center;"><strong>$' . number_format($total_precio_salida, 2) . '</strong></td>
                  <td style="text-align: center;"><strong>' . $total_cantidad_vendida . '</strong></td>
              </tr>
          </tfoot>
          </table>';
} else {
    echo '<table class="table"><tr><td colspan="8" class="text-center">No se encontraron datos en el rango seleccionado.</td></tr></table>';
}

$stmt->close();
$conn->close();
?>
