<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Recibir datos del formulario
$id_producto = $_POST['id_producto'];
$codigo_producto = $_POST['codigo_producto'];
$nombre_producto = $_POST['nombre_producto'];
$descripcion = $_POST['descripcion'];
$medida = $_POST['medida'];



$sql = "UPDATE productos SET codigo_producto='$codigo_producto', nombre_producto='$nombre_producto', descripcion='$descripcion', medida='$medida' WHERE id_producto=$id_producto";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo '<script>
        Swal.fire({
          icon: "success",
          title: "¡DATOS ACTUALIZADOS!",
          text: "Producto actualizado correctamente",
        }).then(function() {
            $("#sub-data").load("./views/productos/principal.php");
        });
      </script>';
} else {
    echo '<script>
        Swal.fire({
          icon: "error",
          title: "¡ERROR!",
          text: "Error al actualizar producto",
        }).then(function() {
            $("#sub-data").load("./views/productos/principal.php");
        });
      </script>';
}

// Cerrar conexión
cerrar_db();
?>
