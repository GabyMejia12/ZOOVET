<?php
@session_start();
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';
$conn = conectar_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $newPassword = $_POST['password'];

    // Hash de la nueva contraseña
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $sql = "UPDATE usuarios SET password = '$hashedPassword' WHERE usuario = '$usuario'";
    
    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error: '; // Incluir información del error
    }
}
?>
