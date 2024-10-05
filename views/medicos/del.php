<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_veterinario = $_POST['id_veterinario'];
$sql = "DELETE FROM veterinario WHERE id_veterinario=$id_veterinario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "Veterinario Eliminado!",
          text: "Registro eliminado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/medicos/principal.php");
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
          text: "Error al eliminar veterinario",
        }).then(function() {
            $("#sub-data").load("./views/medicos/principal.php");
        });
    });
  </script>';
    cerrar_db();
}