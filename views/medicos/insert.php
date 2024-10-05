<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();


$codigo_veterinario = $_POST['codigo_veterinario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$id_usuario = $_POST['id_usuario'];

// Verificar si el usuario ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM veterinario WHERE codigo_veterinario = '$codigo_veterinario' ";
$result_check = $conn->query($sql_check);



if ($result_check) {
    $row = $result_check->fetch_assoc();
    $count = $row['count'];
    if ($row['count'] > 0) {
        // El veterinario ya existe, mostrar mensaje de error
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "warning",
                    title: "AdVERTENCIA!",
                    text: "El veterinario ya existe",
                    }).then(function() {
                        $("#sub-data").load("./views/medicos/principal.php");
                    });
                });
            </script>';
    } else {
        // El usuario no existe, proceder con la inserción
        $sql_insert = "INSERT INTO veterinario(codigo_veterinario, nombre, apellido, id_usuario) 
                    VALUES('$codigo_veterinario', '$nombre', '$apellido', '$id_usuario')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Veterinario registrado correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/medicos/principal.php");
                });
            });
        </script>';
        } else {
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "Error al registrar el veterinario",
                    }).then(function() {
                        $("#sub-data").load("./views/medicos/principal.php");
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
                    $("#sub-data").load("./views/medicos/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
