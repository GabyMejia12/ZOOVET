<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();


$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

// Verificar si el usuario ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM propietario WHERE nombre = '$nombre' AND apellido = '$apellido'";
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
                    text: "El propietario ya existe",
                    }).then(function() {
                        $("#sub-data").load("./views/propietarios/principal.php");
                    });
                });
            </script>';
    } else {
        // El usuario no existe, proceder con la inserción
        $sql_insert = "INSERT INTO propietario(nombre, apellido, telefono, direccion) 
                    VALUES('$nombre', '$apellido', '$telefono', '$direccion')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Propietario registrado correctamente",
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
                    title: "¡Error!",
                    text: "Error al registrar el propietario",
                    }).then(function() {
                        $("#sub-data").load("./views/propietarios/principal.php");
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
                    $("#sub-data").load("./views/propietarios/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
