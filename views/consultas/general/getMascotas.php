<?php
session_start();
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();

$codigo_mascota = $_POST["codigo_mascota"];

$sql = "SELECT codigo_mascota, nombre_mascota FROM mascota WHERE codigo_mascota LIKE ? OR nombre_mascota LIKE ? ORDER BY codigo_mascota ASC LIMIT 0, 10";
$query = $conn->prepare($sql);
$query->execute([$codigo_mascota . '%', $codigo_mascota . '%']);

$html = "";

while ($row = $query->fetch_assoc) {
	$html .= "<li onclick=\"mostrar('" . $row["codigo_mascota"] . "')\">" . $row["codigo_mascota"] . " - " . $row["nombre_mascota"] . "</li>";
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);