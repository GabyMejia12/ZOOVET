<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();


$nombre_producto = $_POST['nombre_producto'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];

// Verificar si el usuario ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM productos WHERE nombre_producto = '$nombre_producto'";
$result_check = $conn->query($sql_check);



if ($result_check) {
    $row = $result_check->fetch_assoc();
    $count = $row['count'];
    if ($row['count'] > 0) {
        // El usuario ya existe, mostrar mensaje de error
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "warning",
                    title: "AdVERTENCIA!",
                    text: "El producto ya existe",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
    } else {
        // El usuario no existe, proceder con la inserción
        $sql_insert = "INSERT INTO productos(nombre_producto, descripcion, cantidad, precio) 
                    VALUES('$nombre_producto', '$descripcion', '$cantidad', '$precio')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Producto registrado correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/productos/principal.php");
                });
            });
        </script>';
        } else {
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "Error al registrar el producto",
                    }).then(function() {
                        $("#sub-data").load("./views/productos/principal.php");
                    });
                });
            </script>';
        }
    }
} else {
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                  icon: "error",
                  title: "¡Error!",
                  text: "Error en el proceso",
                }).then(function() {
                    $("#sub-data").load("./views/productos/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
