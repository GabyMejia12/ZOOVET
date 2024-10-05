<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Recibir datos del formulario
$id_mascota = $_POST['id_mascota'];
$nombre_mascota = $_POST['nombre_mascota'];
$peso = $_POST['peso'];
$edad = $_POST['edad'];
$especie = $_POST['especie'];
$raza = $_POST['raza'];
$sexo = $_POST['sexo'];
$descripcion = $_POST['descripcion'];
$id_propietario = $_POST['id_propietario'];



$sql = "UPDATE mascota SET nombre_mascota='$nombre_mascota', peso='$peso', edad='$edad', especie='$especie', raza='$raza', sexo='$sexo', descripcion='$descripcion' WHERE id_mascota=$id_mascota";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Mascota actualizada correctamente",
        }).then(function() {
            $("#sub-data").load("./views/mascotas/principal.php");
        });
      </script>';
} else {
    echo '<script>
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "Error al actualizar mascota",
        }).then(function() {
            $("#sub-data").load("./views/mascotas/principal.php");
        });
      </script>';
}

// Cerrar conexión
cerrar_db();
?>
