<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_propietario = $_POST['id_propietario'];
$sql = "DELETE FROM propietario WHERE id_propietario=$id_propietario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡Propietario Eliminado!",
          text: "Propietario eliminado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/propietarios/principal.php");
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
          text: "Error al eliminar registro",
        }).then(function() {
            $("#sub-data").load("./views/propietarios/principal.php");
        });
    });
  </script>';
    cerrar_db();
}