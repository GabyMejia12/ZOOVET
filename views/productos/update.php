<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

// Recibir datos del formulario
$id_producto = $_POST['id_producto'];
$nombre_producto = $_POST['nombre_producto'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];



$sql = "UPDATE productos SET nombre_producto='$nombre_producto', descripcion='$descripcion', cantidad='$cantidad', precio='$precio' WHERE id_producto=$id_producto";
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
