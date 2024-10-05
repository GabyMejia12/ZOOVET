<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_usuario = $_POST['id_usuario'];
$sql = "DELETE FROM usuarios WHERE id_usuario=$id_usuario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡Usuario Eliminado!",
          text: "Usuario eliminado correctamente",
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
          text: "Error al eliminar usuario",
        }).then(function() {
            $("#sub-data").load("./views/usuarios/principal.php");
        });
    });
  </script>';
    cerrar_db();
}