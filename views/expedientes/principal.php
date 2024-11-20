<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT m.id_mascota, m.codigo_mascota, m.nombre_mascota, m.raza, m.especie, m.sexo,
p.nombre, p.apellido, p.telefono
FROM mascota AS m
INNER JOIN propietario AS p ON m.id_propietario = p.id_propietario"
;

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

<link rel="stylesheet" href="./public/css/estilosfiltrado.css">


 
<div>
<div class="row">
    <div class="col-md-12">
    <input type="text" id="searchInput" placeholder="Buscar por nombre o código...">
    <button id="searchButton">Buscar</button>
    <a href="#" class="btn btn-success" id="BtnVolver">
        <i class="material-icons"></i> <span>Limpiar Filtro</span>
    </a> <br><br>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Expedientes Mascotas</h2>
                    </div>
                    <div class="col-sm-8 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="./index.php" class="btn btn-success" id="BtnNewPet">
                            <i class="material-icons">arrow_back</i> <span>Regresar</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelExpedientes">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Propietario</th>
                    <th>Teléfono</th>
                    <th>Código Mascota</th>
                    <th>Mascota</th>
                    <th>Sexo</th>
                    <th>Raza</th>
                    <th>Detalle</th>
                    
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    

                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombre']." ".$data['apellido']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['codigo_mascota']; ?></td>
                        <td><?php echo $data['nombre_mascota']; ?></td>
                        <td><?php echo $data['sexo']; ?></td>
                        <td><?php echo $data['raza']; ?></td>                                        
                        <td>
                        <a href="" class="btn text-white BtnDetalleExpediente" id_mascota="<?php echo $data['id_mascota']; ?>" style="background-color: #00008B;"><i class="fa-solid fa-square-poll-vertical"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        
</div>
            </div>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran datos........</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>

// Manejo del botón de detalle por mascota
$(".BtnDetalleExpediente").click(function() {
    var id_mascota = $(this).attr("id_mascota");
    console.log("id mascota: ", id_mascota); // Verifica el id_mascota

    if (!id_mascota) {
        console.error("El ID del mascota no está definido.");
        return; // Salir si no hay id_mascota
    }

    // Cargar el detalle de la mascota
    $("#sub-data").load("./views/expedientes/detallexpediente_mascota.php?id_mascota=" + id_mascota, function(response, status, xhr) {
        if (status == "error") {
            console.error("Error al cargar el detalle del mascota:", xhr.status, xhr.statusText);
            alert("Error al cargar el detalle del mascota.");
        }
    });
    return false;
});

//Buscar
$(document).ready(function () {
    $("#searchButton").click(function () {
        const query = $("#searchInput").val();
        const activePanelId = "DataPanelExpedientes"; // Especificamos que estamos en el panel de Mascotas

        if (query) {
            $.ajax({
                url: './views/expedientes/busqueda.php',
                method: 'POST',
                data: {
                    query: query,
                    panel: activePanelId
                },
                success: function (data) {
                    $("#" + activePanelId).html(data);
                },
                error: function () {
                    alert("Error en la búsqueda");
                }
            });
        } else {
            alert("Ingrese un término de búsqueda.");
        }
    });
});

//Volver

    $("#BtnVolver").click(function() {
        $("#sub-data").load("./views/expedientes/principal.php");
        return false;
    });
</script>