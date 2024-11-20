<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include_once '../models/conexion.php';
include '../controllers/controllersFunciones.php';

$conn = conectar_db();

$query = "SELECT 
             cita.id_cita AS id_cita, 
             CONCAT('Cita de ', mascota.nombre_mascota, ' a las ', DATE_FORMAT(cita.hora, '%h:%i %p')) AS title,
             cita.fecha AS start, 
             DATE_ADD(CONCAT(cita.fecha, ' ', cita.hora), INTERVAL 1 HOUR) AS end
          FROM cita
          JOIN mascota ON cita.id_mascota = mascota.id_mascota";

$result = $conn->query($query);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$citas = [];
while ($row = $result->fetch_assoc()) {
    $citas[] = [
        'id' => $row['id_cita'],
        'title' => $row['title'],     // Nombre de la mascota con la hora AM/PM
        'start' => $row['start'],     // Fecha y hora de inicio de la cita
        'end' => $row['end']          // Fecha y hora de fin de la cita
    ];
}

header('Content-Type: application/json');
echo json_encode($citas);

?>
