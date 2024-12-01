<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Enlace a Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="./public/css/estiloreportes.css">


<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';


$conn = conectar_db();


// Consultar la URL del archivo
$sql = "SELECT archivo FROM ayuda WHERE id_ayuda = 1"; // Cambia el ID según sea necesario
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtener la URL del archivo
    $row = $result->fetch_assoc();
    $archivo = $row['archivo'];
} else {
    $archivo = ""; // No se encontró el archivo
}

// Consultar la URL del archivo
$sql = "SELECT archivo FROM ayuda WHERE id_ayuda = 2"; // Cambia el ID según sea necesario
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtener la URL del archivo
    $row = $result->fetch_assoc();
    $archivovet = $row['archivo'];
} else {
    $archivovet = ""; // No se encontró el archivo
}

$conn->close();
?>



<div>
    <div class="row" id="PanelReporteMedicos">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manual de los Usuarios</h2>
                        </div>                         
                        <div class="col-sm-8 p-0 d-flex justify-content-end align-items-center">
                            <a href="#" class="btn btn-success ocultar-en-impresion mr-2" id="BtnVolver">
                                <i class="material-icons">arrow_back</i> <span>Regresar</span>
                            </a>
                            
                        </div>    
                    </div>
                </div> <br>
                <div class="table-responsive" id="DataPanelProductos">
                    <div id="contenedorManuales">
                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">local_hospital</i></div> <!-- Ícono de veterinario -->
                            <h3>Manual del Veterinario</h3>
                            <p>Guía completa para veterinarios que abarca todas las funcionalidades relevantes del sistema.</p>
                            <a href="<?php echo $archivovet; ?>" class="btn btn-success" id="panel-manual-veterinario" target="_blank">
                                <span>Ver Manual</span>
                            </a>
                        </div>

                        <!-- Tarjeta de asistente médico -->
                        <div class="tarjeta-manual">
                            <div class="icono"><i class="material-icons">people_alt</i></div> <!-- Ícono de asistente médico -->
                            <h3>Manual del Asistente Médico</h3>
                            <p>Manual diseñado para asistentes médicos que explica cómo usar el sistema para gestionar pacientes y citas.</p>
                            <a href=" <?php echo $archivo; ?>" class="btn btn-success" id="panel-manual-asistente" target="_blank">
                                <span>Ver Manual</span>
                            </a>
                        </div>     
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Al hacer clic en el botón "Regresar"
    $("#BtnVolver").click(function() {
        // Cargar el contenido del archivo principal en #sub-data
        $("#sub-data").load("./views/ayuda/principal.php");
        return false; // Evitar la acción por defecto del enlace
    });
</script>