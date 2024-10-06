<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';

$conn = conectar_db();
$usuario = $_SESSION['usuario'];
$tipo = $_SESSION['tipo'];


// Consulta para obtener la información del usuario y del veterinario
$sql = "SELECT u.*, v.* 
        FROM usuarios AS u 
        INNER JOIN veterinario AS v ON u.id_usuario = v.id_usuario 
        WHERE u.usuario = '$usuario'";   

$result = $conn->query($sql);

$row = $result->fetch_assoc();
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$usuario = $row['usuario'];
$tipo = $row['tipo'];
$codigo_veterinario = $row['codigo_veterinario'];


?>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                <h2 class="ml-lg-2">Perfil de Usuario </h2>
                            </div>
                        </div>
                    </div>
                    <div id="DataPanelPerfil">
                        <br>
                        <div class="card border-info text-white mb-6" style="width: 50rem;">
                            <div class="card-header  bg-info border-info">Bienvenido <?php echo $nombre . ' ' . $apellido; ?>
                            </div>
                            <div class="card-body text-info">
                                <h5 class="card-title">Datos</h5>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Nombre</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $nombre;?>" readonly >
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Apellido</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $apellido;?>" readonly >
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Código veterinario</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $codigo_veterinario;?>" readonly >
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Usuario</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $usuario;?>" readonly >
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        var passwordField = document.getElementById("passwordField");
        var button = event.target;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            button.textContent = "Ocultar";
        } else {
            passwordField.type = "password";
            button.textContent = "Mostrar";
        }
    }
    </script>

<?php


   