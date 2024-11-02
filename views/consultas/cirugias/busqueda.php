<?php
session_start();
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
include '../../modal.php';
$conn = conectar_db();

$cont = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'] ?? '';
    $panel = $_POST['panel'] ?? '';

    $resultados = '';

    if ($panel === 'DataPanelCirugias') {
        // Consulta de búsqueda
        $sql = "SELECT a.fecha_consulta, 
                a.RX, a.peso,
                b.nombre, b.telefono, 
                c.codigo_mascota, c.nombre_mascota, c.edad, c.especie, c.raza, c.sexo,
                CONCAT(d.nombre, ' ', d.apellido) AS nombre_completo
                FROM consultas AS a 
                INNER JOIN mascota AS c ON a.id_mascota = c.id_mascota
                INNER JOIN propietario AS b ON c.id_propietario = b.id_propietario
                INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario
                WHERE a.id_tipoconsulta = 3 AND c.nombre_mascota LIKE ? OR c.codigo_mascota LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%$query%";
        $stmt->bind_param("ss", $param, $param);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Comenzamos la tabla
            $resultados .= "<table class='table table-bordered table-hover table-borderless' style='margin: 0 auto; width: 100%'>
                                <thead style='vertical-align: middle; text-align: center;'>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Propietario</th>
                                        <th>Teléfono</th>
                                        <th>Código Mascota</th>
                                        <th>Mascota</th>
                                        <th>Sexo</th>
                                        <th>Raza</th>
                                        <th>Peso</th>
                                        <th>RX</th>
                                        <th>MV</th>
                                    </tr>
                                </thead>
                                <tbody style='vertical-align: middle; text-align: center;'>";
            
            // Rellenamos la tabla con los datos de cada mascota
            while ($row = $result->fetch_assoc()) {

                $resultados .= "<tr>
                                    <td>" . ++$cont . "</td>
                                    <td>" . htmlspecialchars($row['fecha_consulta']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['telefono']) . "</td>
                                    <td>" . htmlspecialchars($row['codigo_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['sexo']) . "</td>
                                    <td>" . htmlspecialchars($row['raza']) . "</td>
                                    <td>" . htmlspecialchars($row['peso']) . "</td>
                                    <td>" . htmlspecialchars($row['RX']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre_completo']) . "</td>
                                    <td>";
                
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