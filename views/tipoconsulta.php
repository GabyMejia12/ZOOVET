<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include_once '../models/conexion.php';
include '../controllers/controllersFunciones.php';

$conn = conectar_db();

// Obtener el mes de la solicitud, o por defecto usar octubre (10)
$mes_a_mostrar = isset($_GET['mes']) ? intval($_GET['mes']) : 10;

// Asumiendo que $mes_a_mostrar ya está definido y contiene el mes correcto
$sql = "SELECT tc.nombre_consulta AS tipo_consulta, COUNT(c.id_tipoconsulta) AS total_consultas 
        FROM consultas c
        JOIN tipo_consulta tc ON c.id_tipoconsulta = tc.id_tipoconsulta
        WHERE MONTH(c.fecha_consulta) = $mes_a_mostrar 
        GROUP BY tc.nombre_consulta";

$result = $conn->query($sql);

// Comprobación de errores en la consulta
if (!$result) {
    echo json_encode(['error' => $conn->error]); // Devuelve el error SQL si hay uno
    exit();
}

$datos = [];
while ($row = $result->fetch_assoc()) {
    $datos[] = [
        'tipo_consulta' => $row['tipo_consulta'],
        'total_consultas' => $row['total_consultas']
    ];
}

$conn->close();

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($datos);

?>
