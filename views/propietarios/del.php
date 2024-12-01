<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_propietario = $_POST['id_propietario'];

// Verificar si el propietario tiene mascotas asignadas
$check_sql = "SELECT COUNT(*) as total FROM mascota WHERE id_propietario = $id_propietario";
$check_result = $conn->query($check_sql);
$row = $check_result->fetch_assoc();

if ($row['total'] > 0) {
    // No se puede eliminar porque tiene mascotas asignadas
    echo '<script>
    $(document).ready(function() {
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "No se puede eliminar el propietario porque tiene mascotas asignadas.",
        }).then(function() {
            $("#sub-data").load("./views/propietarios/principal.php");
        });
    });
  </script>';
} else {
    // Proceder a eliminar el propietario
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
    }
}

cerrar_db();
?>
