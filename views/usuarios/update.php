<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_usuario = $_POST['id_usuario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$password = isset($_POST['password']) && strlen($_POST['password']) != 0 ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
$estado = $_POST['estado'];
$tipo = $_POST['tipo'];

// Si el campo de password tiene algún valor, se actualiza también la contraseña
if ($password !== null) {
    $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email',usuario='$usuario', password='$password', estado='$estado', tipo='$tipo' WHERE id_usuario=$id_usuario";
} else {
    $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email', usuario='$usuario', estado='$estado', tipo='$tipo' WHERE id_usuario=$id_usuario";
}

$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Usuario actualizado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/usuarios/principal.php");
        });
    });
  </script>';
    cerrar_db();
} else {
    echo '<script>
        $(document).ready(function() {
            Swal.fire({
              icon: "error",
              title: "¡ERROR!",
              text: "Error al actualizar usuario",
            }).then(function() {
                $("#sub-data").load("./views/usuarios/principal.php");
            });
        });
      </script>';
    cerrar_db();
}
