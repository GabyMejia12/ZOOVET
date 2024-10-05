<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_cita = $_POST['id_cita'];
$sql = "DELETE FROM cita WHERE id_cita=$id_cita";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡Cita Eliminada!",
          text: "Cita eliminada correctamente",
        }).then(function() {
            $("#sub-data").load("./views/citas/principal.php");
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
          text: "Error al eliminar cita",
        }).then(function() {
            $("#sub-data").load("./views/citas/principal.php");
        });
    });
  </script>';
    cerrar_db();
}