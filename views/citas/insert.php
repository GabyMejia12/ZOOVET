<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();


$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$id_mascota = $_POST['id_mascota'];
$id_veterinario = $_POST['id_veterinario'];


// Verificar si el usuario ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM cita WHERE fecha = '$fecha' AND hora = '$hora' ";
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
                    text: "Ya hay cita reservada en esa hora",
                    }).then(function() {
                        $("#sub-data").load("./views/citas/principal.php");
                    });
                });
            </script>';
    } else {
        // El usuario no existe, proceder con la inserción
        $sql_insert = "INSERT INTO cita(fecha, hora, id_veterinario, id_mascota) 
                    VALUES('$fecha', '$hora', '$id_veterinario', '$id_mascota')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Cita agendada correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/citas/principal.php");
                });
            });
        </script>';
        } else {
            echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "Error al registrar usuario",
                    }).then(function() {
                        $("#sub-data").load("./views/citas/principal.php");
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
                    $("#sub-data").load("./views/citas/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
