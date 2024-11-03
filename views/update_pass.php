<?php
// Conexión a la base de datos
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';
$conn = conectar_db(); // Asegúrate de que esta función devuelva la conexión MySQLi

if (isset($_POST['email'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitiza el email

    // Verificar si el correo electrónico existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql); // Preparar la consulta
    $stmt->bind_param("s", $email); // Vincular el parámetro
    $stmt->execute(); // Ejecutar la consulta
    $result = $stmt->get_result(); // Obtener el resultado

    // Comprobar si se encontró un usuario
    if ($user = $result->fetch_assoc()) { // Cambiado para obtener el usuario
        // Generar un token único y una fecha de expiración (por ejemplo, 1 hora desde ahora)
        $token = bin2hex(random_bytes(50)); // Genera un token seguro
        $expireDate = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Guardar el token y la fecha de expiración en la base de datos
        $updateQuery = "UPDATE usuarios SET reset_token = ?, reset_expire = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sss", $token, $expireDate, $email); // Vincular parámetros
        $updateStmt->execute();

        // Simular el envío de correo
        $resetLink = "http://localhost/pruebacontra/views/formcambiar_pass.php?token=" . $token; // Cambia a localhost para pruebas locales
        echo "<h3>Envío de Correo</h3>";
        echo "Correo enviado a: <strong>$email</strong><br>";
        echo "Asunto: <strong>Recuperación de Contraseña</strong><br>";
        echo "Mensaje: Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a><br>";

    } else {
        echo "El correo no está registrado.";
    }

    // Cerrar las sentencias
    $stmt->close();
    if (isset($updateStmt)) {
        $updateStmt->close();
    }
}
?>
