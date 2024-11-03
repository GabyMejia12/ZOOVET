<?php

include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();

$term = $_GET['term'];
$sql = "SELECT codigo_mascota, nombre_mascota FROM mascota WHERE codigo_mascota LIKE '%$term%' OR nombre_mascota LIKE '%$term%' LIMIT 10";
$result = $conn->query($sql);

$mascotas = [];
while ($row = $result->fetch_assoc()) {
    $mascotas[] = [
        'label' => $row['codigo_mascota'] . " - " . $row['nombre_mascota'],
        'value' => $row['codigo_mascota'],
        'nombre_mascota' => $row['nombre_mascota'] // Incluye el nombre de la mascota en el JSON
    ];
}

echo json_encode($mascotas);
?>
