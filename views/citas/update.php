<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Recibir datos del formulario
$id_cita = $_POST['id_cita'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$id_veterinario = $_POST['id_veterinario'];
$id_mascota = $_POST['id_mascota'];


$sql = "UPDATE cita SET fecha='$fecha', hora='$hora', id_veterinario='$id_veterinario', id_mascota='$id_mascota' WHERE id_cita=$id_cita";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Cita actualizada correctamente",
        }).then(function() {
            $("#sub-data").load("./views/citas/principal.php");
        });
      </script>';
} else {
    echo '<script>
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "Error al actualizar cita",
        }).then(function() {
            $("#sub-data").load("./views/citas/principal.php");
        });
      </script>';
}

// Cerrar conexión
cerrar_db();
?>
