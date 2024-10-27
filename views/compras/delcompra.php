
<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
$id_entrada = $_POST['id_entrada'];

$sql = "DELETE FROM entrada WHERE id_entrada = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_entrada, $id_usuario);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Registro de compra eliminado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al eliminar el registro de compra';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
