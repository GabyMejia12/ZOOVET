<?php
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';

$conn = conectar_db();
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

$sql = "SELECT a.fecha_consulta, a.RX, a.peso,
        b.nombre, b.telefono,
        c.nombre_mascota, c.edad, c.especie, c.raza, c.sexo,
        d.nombre AS NombreVeterinario,
        d.apellido AS ApellidoVeterinario
        FROM consultas AS a
        INNER JOIN mascota AS c ON a.id_mascota = c.id_mascota
        INNER JOIN propietario AS b ON c.id_propietario = b.id_propietario
        INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario
        WHERE a.id_tipoconsulta = 2";

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
if ($result && $result->num_rows > 0) {
    echo '<table class="table table-striped" style="margin: 0 auto; width: 100%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Propietario</th>
                    <th>Teléfono</th>
                    <th>Mascota</th>
                    <th>Sexo</th>
                    <th>Raza</th>
                    <th>Peso</th>
                    <th>RX</th>
                    <th>MV</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">';

    $cont = 0;
    while ($data = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . ++$cont . '</td>
                <td>' . $data['fecha_consulta'] . '</td>
                <td>' . $data['nombre'] . '</td>
                <td>' . $data['telefono'] . '</td>
                <td>' . $data['nombre_mascota'] . '</td>
                <td>' . $data['sexo'] . '</td>
                <td>' . $data['raza'] . '</td>
                <td>' . $data['peso'] . '</td>
                <td>' . $data['RX'] . '</td>
                <td>' . $data['NombreVeterinario'] . ' ' . $data['ApellidoVeterinario'] . '</td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="10" class="text-center">No se encontraron datos en el rango seleccionado.</td></tr>';
}

$stmt->close();
$conn->close();
?>
