
<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_salida = $_POST['id_salida'];

$sql = "DELETE FROM salida WHERE id_salida = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_salida, $id_usuario);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Registro de salida eliminado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al eliminar el registro de salida';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
