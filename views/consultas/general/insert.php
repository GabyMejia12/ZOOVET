<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();


$fecha = $_POST['fecha'];
$codigo_mascota = $_POST['codigo_mascota'];
$peso = $_POST['macota'];
$edad = $_POST['peso'];
$especie = $_POST['especie'];
$raza = $_POST['raza'];
$sexo = $_POST['sexo'];
$descripcion = $_POST['descripcion'];
$id_propietario = $_POST['id_propietario'];
   

// Verificar si el usuario ya existe en la base de datos
$sql_check = "SELECT COUNT(*) AS count FROM mascota WHERE codigo_mascota = '$codigo_mascota' ";
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
                    text: "La mascota ya existe",
                    }).then(function() {
                        $("#sub-data").load("./views/mascotas/principal.php");
                    });
                });
            </script>';
    } else {
        // El usuario no existe, proceder con la inserción
        $sql_insert = "INSERT INTO mascota(codigo_mascota, nombre_mascota, peso, edad, especie, raza, sexo, descripcion, id_propietario) 
                    VALUES('$codigo_mascota', '$nombre_mascota', '$peso', '$edad', '$especie', '$raza', '$sexo', '$descripcion', '$id_propietario')";
        $result_insert = $conn->query($sql_insert);

        if ($result_insert === TRUE) {
            echo '<script>
            $(document).ready(function() {
                Swal.fire({
                icon: "success",
                title: "¡DATOS INGRESADOS!",
                text: "Usuario registrado correctamente",
                }).then(function() {
                    $("#sub-data").load("./views/mascotas/principal.php");
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
                        $("#sub-data").load("./views/mascotas/principal.php");
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
                    $("#sub-data").load("./views/mascotas/principal.php");
                });
            });
        </script>';
}

cerrar_db();
?>
