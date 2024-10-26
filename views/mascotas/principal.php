<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT b.nombre, b.telefono, a.id_mascota, a.nombre_mascota, a.peso, a.edad, a.especie, a.sexo, a.raza, a.estado FROM mascota AS a INNER JOIN propietario AS b ON a.id_propietario = b.id_propietario";

$result = $conn->query($sql);
$cont = 0;


?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Incluye Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Incluye Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div>
<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Mascotas</h2>
                    </div>
                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewPet">
                            <i class="material-icons">&#xE147;</i> <span>Agregar Nueva Mascota</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelMascotas">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-bordered table-hover table-borderless" style="margin: 0 auto; width: 80%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Propietario</th>
                    <th>Teléfono</th>
                    <th>Nombre Mascota</th>
                    <th>Peso</th>
                    <th>Edad</th>
                    <th>Especie</th>
                    <th>Sexo</th>
                    <th>Raza</th>
                    <th>Estado</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    
                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['nombre_mascota']; ?></td>
                        <td><?php echo $data['peso']; ?></td>
                        <td><?php echo $data['edad']; ?></td>
                        <td><?php echo $data['especie']; ?></td>
                        <td><?php echo $data['sexo']; ?></td>
                        <td><?php echo $data['raza']; ?></td>
                        <td><?php echo ($data['estado'] == 1) ? '<b style="color:green;">Activo</b>' : '<b style="color:red;">Inactivo</b>'; ?></td>
                        
                        <!-- td>
                        <a href="" class="btn text-white" style="background-color: #031A58;"><i class="fa-solid fa-key"></i></a>
                    </td -->
                        <td>
                            <a href="" class="btn text-white BtnUpdateMascota" id_mascota="<?php echo $data['id_mascota']; ?>" style="background-color: #9fd86b;"><i class="fa-solid fa-user-pen"></i></a>
                        </td>
                        <td>
                            <?php if ($data['estado'] == 1) : ?>
                                <!-- Botón con estado 1 (activo) -->
                                <a href="" class="btn text-white BtnUpdateEstado" style="background-color: #ff6666;" id_mascota="<?= $data['id_mascota']; ?>" estado="1"><i class="fa-solid fa-ban"></i></a>
                            <?php else : ?>
                                <!-- Botón con estado 0 (inactivo) -->
                                <a href="" class="btn text-white BtnUpdateEstado" style="background-color: #003366;" id_mascota="<?= $data['id_mascota']; ?>" estado="0"><i class="fa-solid fa-check"></i></a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="clearfix">
        <div class="hint-text">Mostrando <b><?php echo $cont; ?></b> de <b>25</b></div>
        <ul class="pagination">
        <li class="page-item disabled"><a href="#">Anterior</a></li>
        <li class="page-item"><a href="#" class="page-link">1</a></li>
        <li class="page-item active"><a href="#" class="page-link">2</a></li>
        <li class="page-item"><a href="#" class="page-link">3</a></li>
        <li class="page-item"><a href="#" class="page-link">Siguiente</a></li>
        </ul>
        </div>
</div>
            </div>
    <?php else : ?>
        <div class="alert alert-danger">
            <b>No se encuentran datos........</b>
        </div>
    <?php endif ?>
    <?php cerrar_db(); ?>
</div>

<script>
    $(document).ready(function() {
        //
        $("#BtnNewPet").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Registrar Mascota';
            $("#DataModalPrincipal").load("./views/mascotas/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });

 
        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {
            if ($('#codigo_mascota').val() === '' || $('#nombre_mascota').val() === '' || $('#peso').val() === '' || $('#edad').val() === '' || $('#especie').val() === '' || $('#raza').val() === '' || $('#sexo').val() === '' || $('#descripcion').val() === '' || $('#id_propietario').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }
            let codigo_mascota, nombre_mascota, peso, edad, especie, raza, sexo, descripcion, $id_propietario;
            codigo_mascota = $('#codigo_mascota').val();
            nombre_mascota = $('#nombre_mascota').val();
            peso = $('#peso').val();
            edad = $('#edad').val();
            especie = $('#especie').val();
            raza = $('#raza').val();
            sexo = $('#sexo').val();
            descripcion = $('#descripcion').val();
            id_propietario = $('#id_propietario').val();

            var formData = {

                codigo_mascota: codigo_mascota,
                nombre_mascota: nombre_mascota,
                peso: peso,
                edad: edad,
                especie: especie,
                raza: raza,
                sexo: sexo,
                descripcion: descripcion,
                id_propietario: id_propietario
            };
            $.ajax({
                type: 'POST',
                url: './views/mascotas/insert.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#codigo_mascota').val('');
                    $('#nombre_mascota').val('');
                    $('#peso').val('');
                    $('#edad').val('');
                    $('#especie').val('');
                    $('#raza').val('');
                    $('#sexo').val('');
                    $('#descripcion').val('');
                    $('#id_propietario').val('');
                    $("#DataPanelMascotas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        //Boton actualizar
        $(".BtnUpdateMascota").click(function() {
            let id_mascota = $(this).attr("id_mascota");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de mascota';
            $("#DataModalPrincipal").load("./views/mascotas/form_update.php?id_mascota=" + id_mascota);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#codigo_mascota').val() === '' || $('#nombre_mascota').val() === '' || $('#peso').val() === '' || $('#edad').val() === '' || $('#especie').val() === '' || $('#raza').val() === '' || $('#sexo').val() === '' || $('#descripcion').val() === '' || $('#id_propietario').val() === '' ) {
                alert('Por favor completa todos los campos.');
                return;
            }

            let id_mascota,nombre_mascota, peso, edad, especie, raza, sexo, descripcion, $id_propietario, codigo_mascota;  
            id_mascota = $('#id_mascota').val();          
            nombre_mascota = $('#nombre_mascota').val();
            peso = $('#peso').val();
            edad = $('#edad').val();
            especie = $('#especie').val();
            raza = $('#raza').val();
            sexo = $('#sexo').val();
            descripcion = $('#descripcion').val();
            id_propietario = $('#id_propietario').val();
            codigo_mascota = $('#codigo_mascota').val();

    var formData = {            
            id_mascota: id_mascota,
            nombre_mascota: nombre_mascota,
            peso: peso,
            edad: edad,
            especie: especie,
            raza: raza,
            sexo: sexo,
            descripcion: descripcion,
            id_propietario: id_propietario,
            codigo_mascota: codigo_mascota
    };
    $.ajax({
        type: 'POST',
        url: './views/mascotas/update.php',
        data: formData,
        dataType: 'html',
        success: function(response) {
            $("#ModalPrincipal").modal("hide");                    
                    $('#nombre_mascota').val('');
                    $('#peso').val('');
                    $('#edad').val('');
                    $('#especie').val('');
                    $('#raza').val('');
                    $('#sexo').val('');
                    $('#descripcion').val('');
                    $('#id_propietario').val('');
                    $('#codigo_mascota').val('');
                    $("#DataPanelMascotas").html(response);
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
        }
    });
    return false;
});
// Proceso cambiar estado
$(document).ready(function() {
    $('.BtnUpdateEstado').click(function() {
        let id_mascota = $(this).attr('id_mascota');
        let estado = $(this).attr('estado'); 

        
        let titulo, texto;
        if (estado == '1') { 
            titulo = '¿Desea inhabilitar la mascota?';
            texto = "¡Esta acción no se puede deshacer!";
            
        } else {
            titulo = '¿Desea habilitar la mascota?';
            texto = "¡Esta acción no se puede deshacer!";
        }

        Swal.fire({
            title: titulo, // Título dinámico
            text: texto,   // Texto dinámico
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
                    url: './views/mascotas/cambiarestado.php',
                    data: { id_mascota: id_mascota, estado: estado },
                    
                    success: function(response) {
                        Swal.fire(
                            'Actualizado',
                            'El estado ha sido actualizado.',
                            'success'
                        );
                        $("#DataPanelMascotas").html(response);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al cambiar estado',
                            'error'
                        );
                    }
                });
            } else {
                Swal.fire(
                    'Cancelado',
                    'El proceso ha sido cancelado.',
                    'error'
                );
            }
        });

        return false;
    });
});



    });
</script>