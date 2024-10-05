<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_propietario = $_POST['id_propietario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$sql = "UPDATE propietario SET nombre='$nombre', apellido='$apellido',telefono='$telefono',direccion='$direccion' WHERE id_propietario=$id_propietario";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Propietario actualizado correctamente",
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
              text: "Error al actualizar propietario",
            }).then(function() {
                $("#sub-data").load("./views/propietarios/principal.php");
            });
        });
      </script>';
    cerrar_db();
}
