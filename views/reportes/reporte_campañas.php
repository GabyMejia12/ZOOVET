<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();

// Verificar si se han enviado las fechas para filtrar
$fi = isset($_POST['fi']) ? $_POST['fi'] : null;
$ff = isset($_POST['ff']) ? $_POST['ff'] : null;


// Consulta para obtener datos de las campañas
$sql = "SELECT a.*, 
d.nombre AS NombreVeterinario,
d.apellido AS ApellidoVeterinario
FROM campañas AS a 
INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario
ORDER BY a.fecha_campaña DESC";

if ($fi && $ff) {
    $sql .= " AND DATE(a.fecha_consulta) BETWEEN '$fi' AND '$ff'";
}

$result = $conn->query($sql);

$cont = 0;
$total_peso = 0; // Para el total de peso, si es necesario

//para contar consulta general
$queryTotalMedicos = "SELECT COUNT(*) as totalConsultaGeneral FROM campañas WHERE id_tipoconsulta = 'Castración'";
$resultTotal = $conn->query($queryTotalMedicos);
$rowTotal = $resultTotal->fetch_assoc();
$totalCastracion = $rowTotal['totalConsultaGeneral'];

//para contar consulta profilactico
$queryTotalProfilactico = "SELECT COUNT(*) as totalConsultaProf FROM consultas WHERE id_tipoconsulta = 'Esterilización'";
$resultProf = $conn->query($queryTotalProfilactico);
$row1 = $resultProf->fetch_assoc();
$totalEsteri = $row1['totalConsultaProf'];


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
    
    <div class="row" id="muestraReporteCampañas">
    
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Detalle de Campañas</h2>
                        </div>
                        <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                            <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                                <i class="material-icons">arrow_back</i> <span>Regresar</span>
                            </a>
                            <a href="#" class="btn btn-success ocultar-en-impresion" id="panel-consultas-detalle" onclick="javascript:imprimirReporteConsultas();">
                                <i class="material-icons">description</i>PDF
                            </a>
                        </div> 
                    </div>
                </div>
                <br>
                <div class="table-responsive" id="DataPanelCampañas">
                
                    <?php if ($result && $result->num_rows > 0) : ?>
                        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                            <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                            
                                <tr>
                                    <th>N°</th>
                                    <th>Fecha</th>
                                    <th>Propietario</th>
                                    <th>Teléfono</th>
                                    <th>Mascota</th>
                                    <th>Peso</th>
                                    <th>Procedimiento</th>
                                    <th>Veterinario</th>                                    
                                    
                                    
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle; text-align: center;">
                                <?php foreach ($result as $data) : ?>
                                    <tr>
                                        <td><?php echo ++$cont; ?></td>
                                        <td><?php echo date('Y-m-d H:i:s', strtotime($data['fecha_campaña'])); ?></td> 
                                        <td><?php echo htmlspecialchars($data['nombre_propietario']); ?></td>   
                                        <td><?php echo htmlspecialchars($data['telefono']); ?></td>   
                                        <td><?php echo htmlspecialchars($data['nombre_mascota']); ?></td>
                                        <td><?php echo htmlspecialchars($data['peso']); ?></td>                                 
                                        <td style="color: <?php echo $data['id_tipoconsulta'] === 'Castración' ? 'blue' : 'green'; ?>;">
                                            <?php echo htmlspecialchars($data['id_tipoconsulta']); ?>
                                        </td>                                        
                                        <td><?php echo htmlspecialchars($data['NombreVeterinario'])." ".$data['ApellidoVeterinario']; ?></td>                                        
                                        
                                    </tr>
                                <?php endforeach; ?>
                                <!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="7" style="text-align: right; font-weight: bold;">Total de castraciones realizadas:</td>
                                    <td style="font-weight: bold;"><?php echo $totalCastracion; ?></td>
                                </tr>
                                <!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="7" style="text-align: right; font-weight: bold;">Total de esterilizaciones realizadas:</td>
                                    <td style="font-weight: bold;"><?php echo $totalEsteri; ?></td>
                                </tr>
                                
                            </tbody>
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
    function imprimirReporteConsultas() {
        var logo = new Image();
        logo.src = "./public/img/logozoovet.png"; // Ruta de la imagen del logo

        logo.onload = function() {
            var carrera = "Reporte de procedimientos realizados en campañas"; // Ajustar título para el encabezado
            var mywindow = window.open('', 'PRINT', 'height=600,width=800');

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
            
            var table = document.getElementById('muestraReporteCampañas').querySelector('table');
            if (table) {
                mywindow.document.write(table.outerHTML);
            }

            mywindow.document.write('</body></html>');

            mywindow.document.close(); 
            mywindow.focus(); 

            mywindow.print();
            mywindow.close();
        };

        logo.onerror = function() {
            alert("Error al cargar el logo para la impresión. Verifique la ruta de la imagen.");
        };
    }
</script>

<script>
    $("#BtnVolver").click(function() {
        $("#sub-data").load("./views/reportes/principal.php");
        return false;
    });
</script>
<script>
//Limpiar filtro
$("#BtnLimpiarFiltro").click(function() {
        $("#sub-data").load("./views/reportes/reporte_campañas.php");
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
            url: './views/reportes/filtrarCampañas.php',
            data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
            success: function(response) {
                $('#DataPanelCampañas').html(response); // Actualiza la tabla con los datos recibidos
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error al cargar los datos: ' + error);
            }
        });
    });
});
</script>
