<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$cont = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'] ?? '';
    $panel = $_POST['panel'] ?? '';

    $resultados = '';

    if ($panel === 'DataPanelExpedientes') {
        // Consulta de búsqueda
        $sql = "SELECT m.id_mascota, m.codigo_mascota, m.nombre_mascota, m.raza, m.especie, m.sexo,
                p.nombre, p.apellido, p.telefono
                FROM mascota AS m
                INNER JOIN propietario AS p ON m.id_propietario = p.id_propietario
                WHERE m.nombre_mascota LIKE ? OR m.codigo_mascota LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%$query%";
        $stmt->bind_param("ss", $param, $param);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Comenzamos la tabla
            $resultados .= "<table class='table table-bordered table-hover table-borderless' style='margin: 0 auto; width: 80%'>
                                <thead style='vertical-align: middle; text-align: center;'>
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
                                <tbody style='vertical-align: middle; text-align: center;'>";
            
            // Rellenamos la tabla con los datos de cada mascota
            while ($row = $result->fetch_assoc()) {

                $resultados .= "<tr>
                                    <td>" . ++$cont . "</td>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['telefono']) . "</td>
                                    <td>" . htmlspecialchars($row['codigo_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['sexo']) . "</td>
                                    <td>" . htmlspecialchars($row['raza']) . "</td>
                                    <td>
                                        <a href='' class='btn text-white BtnDetalleExpediente' id_mascota='" . htmlspecialchars($row['id_mascota']) . "' style='background-color: #00008B;'>
                                            <i class='fa-solid fa-square-poll-vertical'></i>
                                        </a>
                                    </td>
                                    <td>";
                                    
                
                // Agregar botón de estado
                
                $resultados .= "</td></tr>";
            }

            $resultados .= "</tbody></table>";
        } else {
            $resultados = "<p>No se encontraron resultados para '$query'.</p>";
        }
    }

    echo $resultados;
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Incluye Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Incluye Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</script>