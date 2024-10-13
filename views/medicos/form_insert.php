<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlProp = "SELECT * FROM usuarios";
$DataPropietarios = $conn->query($sqlProp);
?>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Veterinario</b></label>
    <select class="form-select" id="id_usuario" name="id_usuario">
        <option disabled selected>Seleccione Usuario</option>
        <?php foreach ($DataPropietarios as $result) : ?>
            <option value="<?php echo $result['id_usuario']; ?>" 
                data-nombre="<?php echo $result['nombre']; ?>" 
                data-apellido="<?php echo $result['apellido']; ?>"
                data-usuario="<?php echo $result['usuario']; ?>">
                <?php echo $result['nombre'] . ' ' . $result['apellido']; ?>
            </option>
        <?php endforeach ?>
    </select>
</div>

<div class="input-group mb-3">
    <span class="input-group-text"><b>Usuario</b></span>
    <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario" readonly>
</div>

<div class="input-group mb-3">
    <span class="input-group-text"><b>Código</b></span>
    <input type="text" class="form-control" placeholder="Ingrese código veterinario" name="codigo_veterinario" id="codigo_veterinario">
</div>

<div class="input-group mb-3">
    <span class="input-group-text"><b>Nombres</b></span>
    <input type="text" class="form-control" placeholder="Ingrese nombres" name="nombre" id="nombre" readonly>
</div>
<div class="input-group mb-3">
    <span class="input-group-text"><b>Apellidos</b></span>
    <input type="text" class="form-control" placeholder="Ingrese apellidos" name="apellido" id="apellido" readonly>
</div>




<script>
$(document).ready(function() {
    // Al seleccionar un usuario del dropdown
    $('#id_usuario').on('change', function() {
        // Obtener el nombre, apellido y usuario seleccionados desde los atributos data
        var nombre = $(this).find(':selected').data('nombre');
        var apellido = $(this).find(':selected').data('apellido');
        var usuario = $(this).find(':selected').data('usuario');
        
        // Asignar los valores a los campos de nombre, apellido y usuario
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#usuario').val(usuario);
    });
});

</script>


