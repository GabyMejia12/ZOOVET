<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
// Conexión a la base de datos
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';
$conn = conectar_db(); // Asegúrate de que esta función devuelva la conexión MySQLi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el token y las contraseñas del formulario
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que las contraseñas coincidan
    if ($new_password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Verificar el token en la base de datos
    $sql = "SELECT * FROM usuarios WHERE reset_token = ? AND reset_expire > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Token válido, proceder a actualizar la contraseña
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT); // Hashear la nueva contraseña

        // Actualizar la contraseña en la base de datos
        $updateQuery = "UPDATE usuarios SET password = ?, reset_token = NULL, reset_expire = NULL WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $hashed_password, $user['email']);
        if ($updateStmt->execute()) {
            echo "<div class='card' style='width: 300px; margin: auto; margin-top: 20px; border: 1px solid #28a745; border-radius: 5px; padding: 20px; text-align: center;'>
                    <h3>Éxito</h3>
                    <p>Contraseña actualizada exitosamente. Puedes iniciar sesión con tu nueva contraseña.</p>
                  </div>";
                  // Redirigir después de un tiempo
            echo "<script>
                        setTimeout(function() {
                            window.location.href = '../index.php'; // Cambia a la ruta de tu página de login
                        }, 3000); // Esperar 3 segundos
                    </script>";
        } else {
            echo "<div class='card' style='width: 300px; margin: auto; margin-top: 20px; border: 1px solid #dc3545; border-radius: 5px; padding: 20px; text-align: center;'>
                    <h3>Error</h3>
                    <p>Error al actualizar la contraseña. Intenta de nuevo más tarde.</p>
                  </div>";
        }
    } else {
        echo "<div class='card' style='width: 300px; margin: auto; margin-top: 20px; border: 1px solid #dc3545; border-radius: 5px; padding: 20px; text-align: center;'>
                <h3>Error</h3>
                <p>El token es inválido o ha expirado.</p>
              </div>";
    }

    // Cerrar las sentencias
    $stmt->close();
    $updateStmt->close();
}
?>
