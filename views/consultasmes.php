<?php
@session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/El_Salvador');
include_once '../models/conexion.php';
include '../controllers/controllersFunciones.php';

$conn = conectar_db();

$sql = "SELECT MONTH(fecha_consulta) AS mes, COUNT(*) AS total_consultas 
        FROM consultas 
        GROUP BY MONTH(fecha_consulta)";
$result = $conn->query($sql);

if (!$result) {
    die('Error en la consulta: ' . $conn->error);
}

$meses = [];
$consultas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meses[] = date("F", mktime(0, 0, 0, $row['mes'], 1)); // Convertir número de mes a nombre
        $consultas[] = $row['total_consultas'];
    }
}

$conn->close();

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode(array_map(function($mes, $total) {
    return ['mes' => $mes, 'total_consultas' => $total];
}, $meses, $consultas));
?>
