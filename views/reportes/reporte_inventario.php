<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$cont = 0;

// Para contar las mascotas
$queryTotalStock = "SELECT SUM(stock) as total FROM productos";
$resultTotal = $conn->query($queryTotalStock);
$rowTotal = $resultTotal->fetch_assoc();
$totalStock = $rowTotal['total'];

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div>
<div class="row" id="PanelReporteInventario">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Inventario</h2>
                    </div>                    
                    <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                        <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                            <i class="material-icons">arrow_back</i> <span>Regresar</span>
                        </a>
                        <a href="#" class="btn btn-success ocultar-en-impresion" id="panel-inventario-detalle" onclick="javascript:imprimirReporteVeterinario();">
                            <i class="material-icons">description</i>PDF
                        </a>
                    </div> 
                </div>
            </div><br>
                    <div class="table-responsive" id="DataPanelProductos">
                        <?php if ($result && $result->num_rows > 0) : ?>
                            <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                                <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                                    <tr>
                                        <th>N°</th>
                                        <th>Código <br>Producto</th>
                                        <th>Nombre <br>Producto</th>
                                        <th>Descripción</th>
                                        <th>Fecha <br> Vencimiento</th> 
                                        <th>Unidad <br>Presentación</th>                   
                                        <th>Precio de <br> Compra</th>                                                          
                                        <th>Total <br>Comprado</th>
                                        <th>Total <br>Vendido</th> 
                                        <th>Existencias</th>   
                                        <th>Estado</th>         
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
                                            <td><?php echo $data['descripcion']; ?></td>  
                                            <td><?php echo $vencimiento ?></td>                       
                                            <td><?php echo $data['medida']; ?></td>
                                            <td>$<?php echo $precio_compra ; ?></td>                        
                                            <td><?php echo $sumaEntradas; ?></td>
                                            <td><?php echo $sumaSalidas; ?></td>
                                            <td><?php echo $data['stock']; ?></td>
                                            <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Disponible</b>' : '<b style="color:red;">No Disponible</b>'; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    <!-- Fila para mostrar el total de personal médico -->
                                    <tr>
                                        <td colspan="9" style="text-align: left; font-weight: bold;">Total Neto de productos:</td>
                                        <td style="font-weight: bold;"><?php echo $totalStock; ?></td>
                                    </tr>
                                </tbody>
                        </table>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <b>No existen productos registrados</b>
                        </div>
                    <?php endif ?>
                    <?php cerrar_db(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function imprimirReporteVeterinario() {
        // Crear una nueva imagen y establecer su fuente
        var logo = new Image();
        logo.src = "./public/img/logozoovet.png"; // Ruta de la imagen del logo

        // Esperar a que la imagen esté completamente cargada
        logo.onload = function() {
            // Crear una nueva ventana para la impresión
            var carrera = "Reporte General de Iventario"; // Ajustar título para el encabezado
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');

            // Escribir el contenido, incluyendo el logo precargado
            mywindow.document.write('<html><head><title>' + carrera + '</title>');

            mywindow.document.write(
                '<div style="text-align: center; margin-bottom: 20px;">' +
                '<img class="img-fluid rounded" src="./public/img/logozoovet.png" width="100px" alt="Logo">' +
                '</div>' +
                '<style>' +
                'body { margin: 0; padding: 0; font-size: 11px; font-family: "Arial", sans-serif; color: #333; }' + // Ajusta el margen y relleno del cuerpo
                'table { border-collapse: collapse; width: calc(100% - 20px); margin: 0 auto; font-size: 13px; page-break-inside: auto; }' + // Asegúrate que la tabla ocupe el 100%
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
            var table = document.getElementById('PanelReporteInventario').querySelector('table');
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

