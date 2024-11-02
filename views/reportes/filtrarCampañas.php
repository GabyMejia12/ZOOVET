<?php
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

// Consulta para obtener todas las campañas
$sql = "SELECT a.*, 
d.nombre AS NombreVeterinario,
d.apellido AS ApellidoVeterinario
FROM campañas AS a 
INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario";


// Agrega el filtro de fechas solo si se proporcionan ambos valores
if ($fechaInicio && $fechaFin) {
    $sql .= " AND a.fecha_campaña BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$cont = 0;

//para contar castraciones con filtro de fechas

$queryTotalMedicos = "SELECT COUNT(*) as totalConsultaGeneral FROM campañas WHERE id_tipoconsulta = 'Castración'";
if ($fechaInicio && $fechaFin) {
    $queryTotalMedicos .= " AND fecha_campaña BETWEEN ? AND ?";
    $stmtTotalMedicos = $conn->prepare($queryTotalMedicos);
    $stmtTotalMedicos->bind_param("ss", $fechaInicio, $fechaFin);
    $stmtTotalMedicos->execute();
    $resultTotal = $stmtTotalMedicos->get_result();
    $rowTotal = $resultTotal->fetch_assoc();
    $totalCastracion = $rowTotal['totalConsultaGeneral'];
    $stmtTotalMedicos->close();
} else {
    $resultTotal = $conn->query($queryTotalMedicos);
    $rowTotal = $resultTotal->fetch_assoc();
    $totalCastracion = $rowTotal['totalConsultaGeneral'];
}

//para contar consulta profilactico
$queryTotalProfilactico = "SELECT COUNT(*) as totalConsultaProf FROM campañas WHERE id_tipoconsulta = 'Esterilización'";

if ($fechaInicio && $fechaFin) {
    $queryTotalProfilactico .= " AND fecha_campaña BETWEEN ? AND ?";
    $stmtTotalProfilactico = $conn->prepare($queryTotalProfilactico);
    $stmtTotalProfilactico->bind_param("ss", $fechaInicio, $fechaFin);
    $stmtTotalProfilactico->execute();
    $resultProf = $stmtTotalProfilactico->get_result();
    $row1 = $resultProf->fetch_assoc();
    $totalEsteri = $row1['totalConsultaProf'];
    $stmtTotalProfilactico->close();
} else {
    $resultProf = $conn->query($queryTotalProfilactico);
    $row1 = $resultProf->fetch_assoc();
    $totalEsteri = $row1['totalConsultaProf'];
}


if ($result && $result->num_rows > 0) {
    echo '<table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
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
            <tbody style="vertical-align: middle; text-align: center;">';

    $cont = 0;
    while ($data = $result->fetch_assoc()) {
        echo '<tr>
        <td>' . ++$cont . '</td>
        <td>' . $data['fecha_campaña'] . '</td>
        <td>' . $data['nombre_propietario'] . '</td>
        <td>' . $data['telefono'] . '</td>
        <td>' . $data['nombre_mascota'] . '</td>
        <td>' . $data['peso'] . '</td>
        <td style="color: ' . ($data['id_tipoconsulta'] === 'Castración' ? 'blue' : 'green') . ';">
            ' . $data['id_tipoconsulta'] . '
        </td>    
        <td>' . $data['NombreVeterinario'] . ' ' . $data['ApellidoVeterinario'] . '</td>
      </tr>';

    }
    echo '<!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="7" style="text-align: right; font-weight: bold;">Total de castraciones realizadas:</td>
                                    <td style="font-weight: bold;">'. $totalCastracion .'</td>
                                </tr>
                                <!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="7" style="text-align: right; font-weight: bold;">Total de esterilizaciones realizadas:</td>
                                    <td style="font-weight: bold;">'. $totalEsteri.'</td>
                                </tr>';
                                
} else {
    echo '<tr><td colspan="10" class="text-center">No se encontraron datos en el rango seleccionado.</td></tr>';
}

$stmt->close();
$conn->close();
?>