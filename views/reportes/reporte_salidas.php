<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
include '../modal_productos.php';
$conn = conectar_db();

// Verificar si se han enviado las fechas para filtrar
$fi = isset($_POST['fi']) ? $_POST['fi'] : null;
$ff = isset($_POST['ff']) ? $_POST['ff'] : null;
if ($fi && $ff) {
    $sql .= " AND DATE(a.fecha_consulta) BETWEEN '$fi' AND '$ff'";
}


// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
$cont = 0;
$total_precio_compra = 0;
$total_cantidad_vendida = 0;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    @media print {.ocultar-en-impresion {display: none;}}
</style>
<style>
    .BtnFiltro {
        padding: 10px 20px;
        background-color: #095169;
        border: none;
        border-radius: 25px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none !important; /* Eliminar el subrayado */
    }
    /* Eliminar el efecto de color en hover */
    .BtnFiltro:hover {
        background-color: #095169; /* Mantener el mismo color */
        color: #fff; /* Mantener el color del texto */
    }
    .button-container {
        display: inline-block; /* Permitir alineación horizontal */
        margin-left: 10px; /* Espacio entre los botones */
    }
    .form-inline {
        display: flex; /* Usar flexbox para alinear elementos */
        align-items: center; /* Alinear verticalmente al centro */
    }
</style>
<div>
<form id="filterForm" class="form-inline mb-3">
            <label for="fecha_inicio" class="mr-2">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control mr-3">

            <label for="fecha_fin" class="mr-2">Fecha de fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control mr-3">

            <button type="submit" class="btn btn-primary BtnFiltro">Filtrar</button>

            <!-- Botón Limpiar Filtro a la par del botón Filtrar -->
            <div class="button-container">
                <a id="BtnLimpiarFiltro" class="BtnFiltro" href="#">
                    Limpiar Filtro
                </a>
            </div>
        </form>
    <div class="row" id="muestraReportesVentas">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Detalle de Salidas</h2>
                        </div>
                        <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                            <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                                <i class="material-icons">arrow_back</i> <span>Regresar</span>
                            </a>
                            <a href="#" class="btn btn-success ocultar-en-impresion" id="panel-inventario-detalle" onclick="javascript:imprimirReporteEntradas();">
                                <i class="material-icons">description</i>PDF
                            </a>
                        </div> 
                    </div>
                </div>
                <br>
                <div class="table-responsive" id="DataPanelProductos">
                    <?php if ($result && $result->num_rows > 0) : ?>
                        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                        <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                            <tr>
                                <th>N°</th>
                                <th>Fecha <br>Movimiento</th>
                                <th>Tipo de Movimiento</th>
                                <th>Código <br> Producto</th>
                                <th>Nombre <br>Producto</th>
                                <th>Unidad <br> Medida</th>
                                <th>Precio de <br> Salida</th>
                                <th>Cantidad <br> Vendida</th>
                            </tr>
                        </thead>

                        <tbody style="vertical-align: middle; text-align: center;">
                            <?php foreach ($result as $data) : ?>
                                <?php
                                // Consultar movimientos de salida
                                $queryMovimientosSalida = "SELECT a.fecha_salida AS fecha_movimiento, b.cantidad_detsalida AS cantidad, b.precio_salida
                                                            FROM salida a
                                                            INNER JOIN detalle_salida b ON a.id_salida = b.id_salida
                                                            WHERE b.id_producto = '" . $data['id_producto'] . "'";

                                if ($fi && $ff) {
                                    $queryMovimientosSalida .= " AND a.fecha_salida BETWEEN '$fi' AND '$ff'";
                                }
                                $resultMovimientosSalida = $conn->query($queryMovimientosSalida);

                                // Combinar movimientos de salida
                                $movimientos = [];
                                while ($row = $resultMovimientosSalida->fetch_assoc()) {
                                    $movimientos[] = [
                                        'tipo' => 'Salida',
                                        'fecha_movimiento' => $row['fecha_movimiento'],
                                        'cantidad' => $row['cantidad'] ?? 0,
                                        'precio_salida' => $row['precio_salida'] ?? 0,
                                    ];
                                    $total_precio_compra += $row['precio_salida'] ?? 0;
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
                                        <td style="color: red;"><?php echo $movimiento['tipo']; ?></td>
                                        <td><?php echo $data['codigo_producto']; ?></td>
                                        <td><?php echo $data['nombre_producto']; ?></td>
                                        <td><?php echo $data['medida']; ?></td>
                                        <td>$<?php echo number_format($movimiento['precio_salida'], 2); ?></td>
                                        <td><?php echo $movimiento['cantidad']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="text-align: center;"><strong>Totales</strong></td>
                                <td style="text-align: center;"><strong>$<?php echo number_format($total_precio_compra, 2); ?></strong></td>
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

<script>
    function imprimirReporteEntradas() {
        // Crear una nueva imagen y establecer su fuente
        var logo = new Image();
        logo.src = "./public/img/logozoovet.png"; // Ruta de la imagen del logo

        // Esperar a que la imagen esté completamente cargada
        logo.onload = function() {
            // Crear una nueva ventana para la impresión
            var carrera = "Reporte General de Salidas"; // Ajustar título para el encabezado
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');

            // Escribir el contenido, incluyendo el logo precargado
            mywindow.document.write('<html><head><title>' + carrera + '</title>');

            mywindow.document.write(
                '<div style="text-align: center; margin-bottom: 20px;">' +
                '<img class="img-fluid rounded" src="./public/img/logozoovet.png" width="100px" alt="Logo">' +
                '</div>' +
                '<style>' +
                'body { margin: 0; padding: 0; font-size: 11px; font-family: "Arial", sans-serif; color: #333; }' + 
                'table { border-collapse: collapse; width: calc(100% - 20px); margin: 0 auto; font-size: 13px; page-break-inside: auto; }' + 
                'th { padding: 12px; background-color: #0066cc; color: white; text-align: center; border: 1px solid #ddd; font-weight: bold; }' +
                'td { padding: 10px; border: 1px solid #ddd; text-align: center; color: #333; }' +
                'tr:nth-child(even) { background-color: #f1f8ff; }' +
                'tr:nth-child(odd) { background-color: #ffffff; }' +
                'table { border: 1px solid #ddd; border-radius: 6px; overflow: hidden; }' +
                'table { box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }' +
                'tr:hover { background-color: #e6f3ff; }' +
                '@media print { .ocultar-en-impresion { display: none; } }' +
                '@media print { thead { display: table-header-group; } }' +
                '</style>'
            );

            mywindow.document.write('</head><body>');
            mywindow.document.write('<h2 style="text-align: center;">' + carrera + '</h2>');
            
            // Extraer solo el contenido de la tabla
            var table = document.getElementById('muestraReportesVentas').querySelector('table');
            if (table) {
                mywindow.document.write(table.outerHTML); // Solo escribe la tabla
            }

            mywindow.document.write('</body></html>');

            mywindow.document.close(); // Necesario para IE >= 10
            mywindow.focus(); // Necesario para IE >= 10

            mywindow.print();
            mywindow.close();
        };

        // Manejo de errores si la imagen no se carga correctamente
        logo.onerror = function() {
            alert("Error al cargar el logo para la impresión. Verifique la ruta de la imagen.");
        };
    }
</script>

<script>
    // Al hacer clic en el botón "Regresar"
    $("#BtnVolver").click(function() {
        // Cargar el contenido del archivo principal en #sub-data
        $("#sub-data").load("./views/reportes/principal.php");
        return false; // Evitar la acción por defecto del enlace
    });
</script>
<script>
//Limpiar filtro
$("#BtnLimpiarFiltro").click(function() {
        $("#sub-data").load("./views/reportes/reporte_salidas.php");
        return false;
    });
</script>
<script>
    //Obtener consultas filtradas
    $(document).ready(function() {
    $('#filterForm').submit(function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        let fechaInicio = $('#fecha_inicio').val();
        let fechaFin = $('#fecha_fin').val();

        // Realiza la solicitud AJAX
        $.ajax({
            type: 'GET',
            url: './views/reportes/filtrarSalidas.php',
            data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
            success: function(response) {
                $('#DataPanelProductos').html(response); // Actualiza la tabla con los datos recibidos
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error al cargar los datos: ' + error);
            }
        });
    });
});
</script>
