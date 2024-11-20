<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';

$conn = conectar_db();
$usuario = $_SESSION['usuario'];
$tipo = $_SESSION['tipo'];

// Consulta para obtener la información del usuario y del veterinario
$sql = "SELECT u.id_usuario AS id_usuario, u.nombre AS nombre, u.apellido AS apellido, u.usuario, u.tipo, u.password,u.email,
               v.codigo_veterinario 
        FROM usuarios u 
        LEFT JOIN veterinario v ON u.id_usuario = v.id_usuario 
        WHERE u.usuario = '$usuario'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_usuario = $row['id_usuario'];
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$email = $row['email'];
$usuario = $row['usuario'];
$tipo = $row['tipo'];
$codigo_veterinario = $row['codigo_veterinario'];
$password = $row['password']; // Asumiendo que el campo es 'password' y contiene el hash
?>

<div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Perfil de Usuario</h2>
                        </div>
                    </div>
                </div>
                <div id="DataPanelPerfil">
                    <br>
                    <div class="card border-info text-white mb-6" style="width: 50rem;">
                        <div class="card-header bg-info border-info">
                            Bienvenido <?php echo $nombre . ' ' . $apellido; ?>
                        </div>
                        <div class="card-body text-info">
                            <h5 class="card-title">Datos</h5>
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nombre</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $nombre;?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Apellido</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $apellido;?>" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Correo electrónico</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $email;?>" readonly>
                            </div>

                            <?php if ($tipo == 2): ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Código veterinario</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $codigo_veterinario;?>" readonly>
                            </div>
                            <?php endif; ?>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Usuario</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" value="<?php echo $usuario;?>" readonly>
                            </div>

                            <!-- Botón para actualizar contraseña -->
                            <div class="input-group mb-3">
                                <button type="button" id="ActualizarContraseña" class="btn btn-outline-info">Actualizar contraseña</button>
                            </div>

                            <!-- Campo nueva contraseña con icono para mostrar/ocultar -->
                            <div class="input-group mb-3" id="passwordFields" style="display:none;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nueva Contraseña</span>
                                </div>
                                <input type="password" class="form-control" id="newPassword" placeholder="Ingrese nueva contraseña">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                        <i class="fas fa-eye" id="newPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Campo confirmar contraseña con icono para mostrar/ocultar -->
                            <div class="input-group mb-3" id="confirmPasswordField" style="display:none;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Confirmar Contraseña</span>
                                </div>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirme su nueva contraseña">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Mensaje de validación -->
                            <div class="input-group mb-3" id="passwordMessage" style="display:none;">
                                <span id="passwordErrorMessage"></span>
                            </div>

                            <!-- Botón para guardar la nueva contraseña -->
                            <div class="input-group mb-3" id="savePasswordButton" style="display:none;">
                                <button type="button" class="btn btn-outline-success BtnActualizarContra" data-usuario="<?php echo $usuario; ?>">Guardar Contraseña</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#ActualizarContraseña').click(function() {
        $('#passwordFields, #confirmPasswordField, #savePasswordButton').toggle();
    });

    // Funciones para mostrar/ocultar contraseñas
    $('#toggleNewPassword').click(function() {
        let input = $('#newPassword');
        let icon = $('#newPasswordIcon');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggleConfirmPassword').click(function() {
        let input = $('#confirmPassword');
        let icon = $('#confirmPasswordIcon');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#confirmPassword').on('input', function() {
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();
        var message = $('#passwordErrorMessage');

        if (newPassword === confirmPassword && newPassword !== "") {
            message.css('color', 'green').text('Las contraseñas coinciden.');
        } else {
            message.css('color', 'red').text('Las contraseñas no coinciden o están vacías.');
        }
        $('#passwordMessage').show();
    });

    $(document).ready(function() {
        $('.BtnActualizarContra').click(function() {
            let usuario = $(this).data('usuario');
            let newPassword = $('#newPassword').val();
            let confirmPassword = $('#confirmPassword').val();

            // Verificar si los campos de contraseña están vacíos
            if (newPassword === "" || confirmPassword === "") {
                Swal.fire('Error', 'Debe escribir la nueva contraseña y confirmarla', 'warning');
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }

            Swal.fire({
                title: 'Actualizar contraseña',
                text: "¿Desea actualizar la contraseña?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: './views/actualizarcontra.php',
                        data: {
                            usuario: usuario,
                            password: newPassword
                        },
                        success: function(response) {
                            if (response.trim() === 'success') {
                                Swal.fire('Éxito', 'Contraseña actualizada correctamente', 'success');
                                $('#passwordFields, #confirmPasswordField, #savePasswordButton, #passwordMessage').hide();
                            } else {
                                Swal.fire('Error', 'No se pudo actualizar la contraseña: ' + response, 'error');
                            }
                        }
                    });
                }
            });
        });
    });
</script>
