<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Consulta para obtener la información de las mascotas junto con sus propietarios
$sql = "SELECT b.*, a.nombre, a.apellido 
        FROM mascota b
        INNER JOIN propietario a ON a.id_propietario = b.id_propietario";
$result = $conn->query($sql);

// Consulta para contar mascotas por especie y sexo
$queryEspecies = "
    SELECT especie, 
           SUM(CASE WHEN sexo = 'hembra' THEN 1 ELSE 0 END) AS totalHembras,
           SUM(CASE WHEN sexo = 'macho' THEN 1 ELSE 0 END) AS totalMachos
    FROM mascota
    GROUP BY especie
";
$resultEspecies = $conn->query($queryEspecies);

// Inicializar contadores generales
$totalMascotas = 0;
$totalHembrasGeneral = 0;
$totalMachosGeneral = 0;



$cont = 0;
?>
<link rel="stylesheet" href="./public/css/estiloreportes.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div>
    <div class="row" id="PanelReporteMascotas">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                <div class="row">
                    <div class="col-sm-4 p-0 d-flex align-items-center">
                        <h2 class="ml-lg-2">Mascotas</h2>
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

                </div> <br>
                <div class="table-responsive" id="DataPanelProductos">
                    <?php if ($result && $result->num_rows > 0) : ?>
                        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                            <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                                <tr>
                                    <th>N°</th>
                                    <th>Código <br>Mascota</th>
                                    <th>Nombre <br>Mascota</th>
                                    <th>Peso</th>
                                    <th>Edad</th>
                                    <th>Especie</th>
                                    <th>Raza</th>
                                    <th>Sexo</th>
                                    <th>Descripción</th>
                                    <th>Propietario</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle; text-align: center;">
                                <?php foreach ($result as $data) : ?>                                    
                                    <tr>
                                        <td><?php echo ++$cont; ?></td>
                                        <td><?php echo $data['codigo_mascota']; ?></td>
                                        <td><?php echo $data['nombre_mascota']; ?></td>  
                                        <td><?php echo $data['peso']; ?></td>
                                        <td><?php echo $data['edad']; ?></td>
                                        <td><?php echo $data['especie']; ?></td>
                                        <td><?php echo $data['raza']; ?></td>
                                        <td><?php echo $data['sexo']; ?></td>
                                        <td><?php echo $data['descripcion']; ?></td>
                                        <td><?php echo $data['nombre'] . ' ' . $data['apellido']; ?></td>  <!-- Muestra el propietario concatenado -->
                                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Activo</b>' : '<b style="color:red;">Inactivo</b>'; ?></td>                                  
                                    </tr>
                                <?php endforeach ?>
                                
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <b>No existen mascotas registradas</b>
                        </div>
                    <?php endif ?>
                    <?php cerrar_db(); ?>
                </div>
                <div class="reporte-total">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Especie</th> <!-- Columna de especie más ancha -->
                                <th>Hembras</th>
                                <th>Machos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while ($row = $resultEspecies->fetch_assoc()): 
                                // Sumar los valores al total general
                                $totalHembrasGeneral += $row['totalHembras'];
                                $totalMachosGeneral += $row['totalMachos'];
                                $totalMascotas += $row['totalHembras'] + $row['totalMachos'];
                                $totalGeneralMascotas = $totalMascotas;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['especie']); ?></td>
                                <td><?php echo $row['totalHembras']; ?></td>
                                <td><?php echo $row['totalMachos']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <tr>
                                <td><b>Total</b></td>
                                <td><b><?php echo $totalHembrasGeneral; ?></b></td>
                                <td><b><?php echo $totalMachosGeneral; ?></b></td>
                            </tr>
                            <tr>
                                <td><b>Total de mascotas registradas</b></td>
                                <td colspan="2"><b><?php echo $totalGeneralMascotas; ?></b></td>
                                
                            </tr>
                        </tbody>
                    </table>
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
        var carrera = "Reporte General de Mascotas"; // Ajustar título para el encabezado
        var mywindow = window.open('', 'PRINT', 'height=600,width=800');
        var carrera2 = "Total de mascotas según especie y sexo";

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
        
        // Extraer solo el contenido de la primera tabla
        var table = document.getElementById('PanelReporteMascotas').querySelector('table');
        if (table) {
            mywindow.document.write(table.outerHTML); // Solo escribe la tabla de mascotas
        }
        mywindow.document.write('<div style="margin: 50px 0;"></div>'); // Esto añade un espacio de 20px entre las tablas
        mywindow.document.write('<h2 style="text-align: center;">' + carrera2 + '</h2>');

        // Agregar la segunda tabla con totales, usando el mismo enfoque de extraer el HTML
        var totalTable = document.querySelector('.reporte-total table'); // Selecciona la segunda tabla en el HTML
        if (totalTable) {
            mywindow.document.write(totalTable.outerHTML); // Solo escribe la tabla de totales
        }

        mywindow.document.write('</body></html>'); // Cierra el HTML del documento

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





