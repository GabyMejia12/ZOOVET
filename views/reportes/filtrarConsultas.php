<?php
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

// Consulta para obtener todas las consultas junto con el tipo de consulta
$sql = "SELECT a.peso as pesoconsulta,a.fecha_consulta,a.id_tipoconsulta, b.nombre_consulta , c.*, d.nombre AS NombreVeterinario, d.apellido AS ApellidoVeterinario
        FROM consultas a 
        INNER JOIN tipo_consulta b 
        ON a.id_tipoconsulta = b.id_tipoconsulta
        INNER JOIN mascota c
        ON a.id_mascota=c.id_mascota         
        INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario";


// Agrega el filtro de fechas solo si se proporcionan ambos valores
if ($fechaInicio && $fechaFin) {
    $sql .= " AND a.fecha_consulta BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$cont = 0;

//para contar consulta general con filtro de fechas
$queryTotalMedicos = "SELECT COUNT(*) as totalConsultaGeneral FROM consultas WHERE id_tipoconsulta = 1";
if ($fechaInicio && $fechaFin) {
    $queryTotalMedicos .= " AND fecha_consulta BETWEEN ? AND ?";
    $stmtTotalMedicos = $conn->prepare($queryTotalMedicos);
    $stmtTotalMedicos->bind_param("ss", $fechaInicio, $fechaFin);
    $stmtTotalMedicos->execute();
    $resultTotal = $stmtTotalMedicos->get_result();
    $rowTotal = $resultTotal->fetch_assoc();
    $totalmedicos = $rowTotal['totalConsultaGeneral'];
    $stmtTotalMedicos->close();
} else {
    $resultTotal = $conn->query($queryTotalMedicos);
    $rowTotal = $resultTotal->fetch_assoc();
    $totalmedicos = $rowTotal['totalConsultaGeneral'];
}

//para contar consulta profilactico con filtro de fechas
$queryTotalProfilactico = "SELECT COUNT(*) as totalConsultaProf FROM consultas WHERE id_tipoconsulta = 2";
if ($fechaInicio && $fechaFin) {
    $queryTotalProfilactico .= " AND fecha_consulta BETWEEN ? AND ?";
    $stmtTotalProfilactico = $conn->prepare($queryTotalProfilactico);
    $stmtTotalProfilactico->bind_param("ss", $fechaInicio, $fechaFin);
    $stmtTotalProfilactico->execute();
    $resultProf = $stmtTotalProfilactico->get_result();
    $row1 = $resultProf->fetch_assoc();
    $totalProfilactico = $row1['totalConsultaProf'];
    $stmtTotalProfilactico->close();
} else {
    $resultProf = $conn->query($queryTotalProfilactico);
    $row1 = $resultProf->fetch_assoc();
    $totalProfilactico = $row1['totalConsultaProf'];
}

//para contar consulta cirugia con filtro de fechas
$queryTotalCirugia = "SELECT COUNT(*) as totalConsultaProf FROM consultas WHERE id_tipoconsulta = 3";
if ($fechaInicio && $fechaFin) {
    $queryTotalCirugia .= " AND fecha_consulta BETWEEN ? AND ?";
    $stmtTotalCirugia = $conn->prepare($queryTotalCirugia);
    $stmtTotalCirugia->bind_param("ss", $fechaInicio, $fechaFin);
    $stmtTotalCirugia->execute();
    $resultCirugia = $stmtTotalCirugia->get_result();
    $row2 = $resultCirugia->fetch_assoc();
    $totalCirugia = $row2['totalConsultaProf'];
    $stmtTotalCirugia->close();
} else {
    $resultCirugia = $conn->query($queryTotalCirugia);
    $row2 = $resultCirugia->fetch_assoc();
    $totalCirugia = $row2['totalConsultaProf'];
}

if ($result && $result->num_rows > 0) {
    echo '<table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 100%">
                            <thead style="background-color: #34495e; color: white; font-weight: bold; text-align: center; vertical-align: middle;">
                            
                                <tr>
                                    <th>N°</th>
                                    <th>Fecha de Consulta</th>
                                    <th>Tipo de Consulta</th>
                                    <th>Mascota</th>
                                    <th>Peso <br>a fecha</th>
                                    <th>Veterinario</th>                                    
                                    
                                    
                                </tr>
                            </thead>
            <tbody style="vertical-align: middle; text-align: center;">';

    $cont = 0;
    while ($data = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . ++$cont . '</td>
                <td>' . $data['fecha_consulta'] . '</td>
                <td style="color: ' . ($data['id_tipoconsulta'] == 1 ? 'red' : ($data['id_tipoconsulta'] == 2 ? 'blue' : 'green')) . ';">
    ' . $data['nombre_consulta'] . '
</td>

                
                <td>' . $data['nombre_mascota'] . '</td>
                <td>' . $data['pesoconsulta'] . '</td>
                <td>' . $data['NombreVeterinario'] . ' '.$data['ApellidoVeterinario'] .'</td>
              </tr>
              ';
    }
    echo '<!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="5" style="text-align: right; font-weight: bold;">Total de consultas general:</td>
                                    <td style="font-weight: bold;">'. $totalmedicos .'</td>
                                </tr>
                                <!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="5" style="text-align: right; font-weight: bold;">Total de consultas por control profilactico:</td>
                                    <td style="font-weight: bold;">'. $totalProfilactico.'</td>
                                </tr>
                                <!-- Fila para mostrar el total de consultas por tipo -->
                                <tr>
                                    <td colspan="5" style="text-align: right; font-weight: bold;">Total de cirugías:</td>
                                    <td style="font-weight: bold;">'.$totalCirugia.'</td>
                                </tr>';
} else {
    echo '<tr><td colspan="10" class="text-center">No se encontraron datos en el rango seleccionado.</td></tr>';
}

$stmt->close();
$conn->close();
?>