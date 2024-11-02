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
$total_precio_compra = 0;
$total_cantidad_comprada = 0;

if ($result && $result->num_rows > 0) {
    echo '<table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                <tr>
                    <th>N°</th>
                    <th>Fecha <br>Movimiento</th>
                    <th>Tipo de Movimiento</th>
                    <th>Código <br> Producto</th>
                    <th>Nombre <br>Producto</th>
                    <th>Fecha <br> Vencimiento</th>
                    <th>Unidad <br> Medida</th>
                    <th>Precio de <br> Compra</th>
                    <th>Cantidad <br> Comprada</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">';

    while ($data = $result->fetch_assoc()) {
        // Consultar movimientos de entrada para cada producto
        $queryMovimientosEntrada = "SELECT a.fecha AS fecha_movimiento, b.total AS cantidad, b.vencimiento, b.precio_compra
                                    FROM entrada a
                                    INNER JOIN detalle_entrada b ON a.id_entrada = b.id_entrada
                                    WHERE b.id_producto = ?";
        
        if ($fechaInicio && $fechaFin) {
            $queryMovimientosEntrada .= " AND a.fecha BETWEEN ? AND ?";
            $stmtMovimientos = $conn->prepare($queryMovimientosEntrada);
            $stmtMovimientos->bind_param("sss", $data['id_producto'], $fechaInicio, $fechaFin);
        } else {
            $stmtMovimientos = $conn->prepare($queryMovimientosEntrada);
            $stmtMovimientos->bind_param("s", $data['id_producto']);
        }

        $stmtMovimientos->execute();
        $resultMovimientosEntrada = $stmtMovimientos->get_result();

        // Combinar movimientos de entrada
        $movimientos = [];
        while ($row = $resultMovimientosEntrada->fetch_assoc()) {
            $movimientos[] = [
                'tipo' => 'Entrada',
                'fecha_movimiento' => $row['fecha_movimiento'],
                'cantidad' => $row['cantidad'] ?? 0,
                'vencimiento' => $row['vencimiento'] ?? '-',
                'precio_compra' => $row['precio_compra'] ?? 0,
            ];
            $total_precio_compra += $row['precio_compra'] ?? 0;
            $total_cantidad_comprada += $row['cantidad'] ?? 0;
        }

        // Ordenar movimientos por fecha
        usort($movimientos, function ($a, $b) {
            return strtotime($a['fecha_movimiento']) - strtotime($b['fecha_movimiento']);
        });

        // Mostrar cada movimiento en una fila
        foreach ($movimientos as $movimiento) {
            echo '<tr>
                    <td>' . ++$cont . '</td>
                    <td>' . $movimiento['fecha_movimiento'] . '</td>
                    <td style="color: ' . ($movimiento['tipo'] === 'Salida' ? 'red' : 'green') . ';">' . $movimiento['tipo'] . '</td>
                    <td>' . $data['codigo_producto'] . '</td>
                    <td>' . $data['nombre_producto'] . '</td>
                    <td>' . $movimiento['vencimiento'] . '</td>
                    <td>' . $data['medida'] . '</td>
                    <td>$' . number_format($movimiento['precio_compra'], 2) . '</td>
                    <td>' . $movimiento['cantidad'] . '</td>
                  </tr>';
        }
    }

    // Mostrar totales al final
    echo '</tbody>
          <tfoot>
              <tr>
                  <td colspan="7" style="text-align: center;"><strong>Totales</strong></td>
                  <td style="text-align: center;"><strong>$' . number_format($total_precio_compra, 2) . '</strong></td>
                  <td style="text-align: center;"><strong>' . $total_cantidad_comprada . '</strong></td>
              </tr>
          </tfoot>
          </table>';
} else {
    echo '<tr><td colspan="10" class="text-center">No se encontraron datos en el rango seleccionado.</td></tr>';
}

$stmt->close();
$conn->close();
?>