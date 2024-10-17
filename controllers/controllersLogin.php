<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php
@session_start();
include '../models/conexion.php';
include './controllersFunciones.php';
$conn = conectar_db();

if (isset($_POST['BtnLogin'])) {
    $usuario = $_POST['usuario'];
    $clave = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        /* Esta parte del código recupera los datos del conjunto de resultados de la base de datos
        después de ejecutar la consulta SQL. A continuación se muestra un desglose de lo que hace
        cada línea: */
        $row = $result->fetch_assoc();
        $id_usuario = $row['id_usuario'];
        $hash = $row['password'];
        $estado = $row['estado'];
        $tipo = $row['tipo'];

        if($estado == 1){
           /* Esta parte del código es responsable de verificar la contraseña ingresada por el usuario
           durante el proceso de inicio de sesión. Aquí hay un desglose de lo que hace: */
            if(password_verify($clave,$hash)){
                /* Las líneas `['LoginAccess'] = 1;`, `['idusuario'] = ;`,
                `['usuario'] = ;`, y `['tipo '] = ;` están
                configurando variables de sesión en PHP. Esto es lo que hace cada una de estas
                líneas: */
                $_SESSION['LoginAccess'] = 1;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['usuario'] = $usuario;
                $_SESSION['tipo'] = $tipo;
                /* La línea `header("Ubicación: ../index.php");` es una función PHP que envía un
                encabezado HTTP sin formato para redirigir al usuario a una página diferente. En
                este caso, redirige al usuario a la página `index.php` ubicada en el directorio
                principal (`../`). Esto se usa comúnmente para redirigir a los usuarios después de
                que se haya realizado una determinada acción, como después de un inicio de sesión
                exitoso o cuando ocurre un error. */
                //header("Location: ../index.php");
                /*echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "success",
                            title: "¡Bienvenido/a!",
                            text: "Has iniciado sesión correctamente.",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            window.location.href = "../index.php";
                        });
                    });
                </script>';*/
                echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            html: `<div style="text-align: center;">
                    <img src="../public/img/cargando.gif" alt="Cargando..." style="width: 250px; height: 150px;">
                    
                </div>`,
            title: "¡Bienvenido/a!",
            showConfirmButton: false,
            allowOutsideClick: false, // Evita que el usuario cierre el cuadro de diálogo haciendo clic fuera de él
            didOpen: () => {                
                setTimeout(() => {
                    window.location.href = "../index.php"; // Redirige al usuario después de un tiempo
                }, 3000); // Ajusta el tiempo según sea necesario
            }
        });
    });
</script>';


            }else{
                /*echo '<script>
                    var msj = "Contraseña incorrecta...";
                    alert(msj);
                    setTimeout(function(){
                        window.location.href = "../index.php";
                    },1000);
                </script>'; */
                
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "¡Ha ocurrido un problema!",
                            text: "La contraseña es incorrecta"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "../index.php";
                            }
                        });
                    });
                </script>';    
            }
        }else{
            /*echo '<script>
                var msj = "El usuario sin permisos de acceso...";
                alert(msj);
                setTimeout(function(){
                    window.location.href = "../index.php";
                },1000);
            </script>';*/

            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "¡Ha ocurrido un problema!",
                    text: "El usuario no posee permisos de acceso"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../index.php";
                    }
                });
            });
        </script>';
        }
    } else {
        /*echo '<script>
                var msj = "El usuario no existe...";
                alert(msj);
                setTimeout(function(){
                    window.location.href = "../index.php";
                },1000);
            </script>';*/

            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "¡Ha ocurrido un problema!",
                    text: "El usuario no existe"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../index.php";
                    }
                });
            });
        </script>';
    }
} else {
    header("Location: ../index.php");
}
?>


