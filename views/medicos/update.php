<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_veterinario = $_POST['id_veterinario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];


$sql = "UPDATE veterinario SET nombre='$nombre', apellido='$apellido' WHERE id_veterinario=$id_veterinario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Médico actualizado correctamente",
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
              text: "Error al actualizar médico",
            }).then(function() {
                $("#sub-data").load("./views/medicos/principal.php");
            });
        });
      </script>';
    cerrar_db();
}
