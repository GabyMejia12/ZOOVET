<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

// Obtén los parámetros de la URL
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];
$nombreMascota = $_GET['nombreMascota'];

<?php
include 'conexion.php'; // Archivo de conexión

// Obtener los parámetros de la URL
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];
$nombreMascota = $_GET['nombreMascota'];

// Consulta SQL
$sql = "SELECT consultas.*, mascota.nombre_mascota AS nombre_mascota
        FROM consultas
        JOIN mascota ON consultas.id_mascota = mascota.id_mascota
        WHERE fecha_consulta BETWEEN ? AND ?
        AND mascota.nombre_mascota LIKE ?
        ORDER BY fecha_consulta DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la consulta SQL: " . $conn->error);
}

$nombreMascotaParam = "%" . $nombreMascota . "%";
$stmt->bind_param("sss", $fechaInicio, $fechaFin, $nombreMascotaParam);
$stmt->execute();
$result = $stmt->get_result();

// Generar HTML para mostrar los resultados
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID Consulta</th>
                <th>Fecha Consulta</th>
                <th>Nombre Mascota</th>
                <th>Detalles</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_consulta']}</td>
                <td>{$row['fecha_consulta']}</td>
                <td>{$row['nombre_mascota']}</td>
                <td>{$row['detalles']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados.";
}

$stmt->close();
?>
