<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_mascota = $_POST['id_mascota'];
$estado = $_POST['estado'];

if ($estado == '1') {
  $nuevo_estado = '0';  // Si el estado es 1, lo cambia a 0
} else {
  $nuevo_estado = '1';  // Si el estado es 0, lo cambia a 1
}

$sql = "UPDATE mascota SET  estado='$nuevo_estado' WHERE id_mascota=$id_mascota";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "El estado de la mascota fue actualizado",
        }).then(function() {
            $("#sub-data").load("./views/mascotas/principal.php");
        });
      </script>';
} else {
    echo '<script>
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "Error al actualizar estado de la mascota",
        }).then(function() {
            $("#sub-data").load("./views/mascotas/principal.php");
        });
      </script>';
}

// Cerrar conexión
cerrar_db();

?>