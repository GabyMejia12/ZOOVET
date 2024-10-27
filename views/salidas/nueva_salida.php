<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$id_usuario = $_SESSION['id_usuario'];
//$id_usuario = $_POST['id_usuario'];
//echo $id_usuario;
$sql = "SELECT *
        FROM usuarios u 
        WHERE u.id_usuario = '$id_usuario'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_usuario = $row['id_usuario'];
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$usuario = $row['usuario'];
$tipo_salida = 'venta';


$salidasEstado0="SELECT COUNT(*) AS tsalidas FROM salida WHERE  estado =0 AND id_usuario='$id_usuario'";
$result1 = $conn->query($salidasEstado0);
$row1 = $result1->fetch_assoc();
$tsalidas = $row1['tsalidas'];
// Obtener la fecha_salida y hora actual del sistema
//$fecha_actual = date("Y-m-d H:i:s");


$sqlProp = "SELECT * FROM tipo_salida";
$DataTipoSalida = $conn->query($sqlProp);

?>
<div>
<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Salidas</h2>
                    </div>
                </div>
            </div>
            <div id="DataPanelPerfil">
                <br>
                <div class="card border-info text-white mb-6" style="width: 50rem;">
                <div class="card-header bg-info border-info">
                    Registrar salida 
                    <?php if ($tsalidas == 0) : ?>
                        <!-- Botón deshabilitado, no realiza ninguna acción -->
                        <a href="javascript:void(0);" style="float: right;" class="btn btn-outline-warning bloqueado" disabled>
                            <i class="fa-solid fa-cart-shopping"></i> <?php echo $tsalidas; ?>
                        </a>
                    <?php else : ?>
                        <!-- Botón habilitado, realiza la acción que definas -->
                        <a href="ruta_para_realizar_salida.php" style="float: right;" class="btn btn-outline-warning" id="BtnPreSalida">
                            <i class="fa-solid fa-cart-shopping"></i> <?php echo $tsalidas; ?>
                        </a>
                    <?php endif ?>
                </div>
                    <div class="card-body text-info">
                        <h5 class="card-title">Datos del Usuario</h5>
                        
                        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" readonly>
                        
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
                                <span class="input-group-text" id="basic-addon1">Tipo Salida</span>
                            </div>
                            <select class="custom-select" id="id_tiposalida" name="id_tiposalida">
                                <option disabled selected>Tipo Salida</option>
                                <?php foreach ($DataTipoSalida as $result) : ?>
                                <option value="<?php echo $result['id_tiposalida']; ?>"><?php echo $result['nombre_salida']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>  
                        <!-- Botón para registrar entrada                      
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><b>Fecha</b></span>
                            <input type="date" class="form-control" placeholder="" name="fecha_salida" id="fecha_salida">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><b>Hora</b></span>
                            <input type="time" class="form-control" placeholder="hora" name="hora" id="hora">
                        </div> -->  
                        <!-- Botón para registrar entrada-->
                        <div class="input-group mb-3">
                            <button type="button" id="BtnReg-Salida" class="btn btn-outline-info">Procesar salida</button>
                        </div>                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div>
<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">                
            <div id="DataPanelPreSalida">
                
            </div>
        </div>
    </div>
</div> 
</div>
<script>
$(document).ready(function() {
    $("#BtnReg-Salida").click(function() {
        // Verificar que todos los campos requeridos no estén vacíos
        if (//$('#id_usuario').val() === '' ||
            $('#fecha_salida').val() === '',
            $('#hora').val() === '',
            $('#id_tiposalida').val() === ''
            ) {
            alert('Por favor ingrese todos los datos');
            return;
        }

        // Obtener los valores de los campos
        //let id_usuario = $('#id_usuario').val();
        let fecha_salida = $('#fecha_salida').val();
        let hora = $('#hora').val();
        let id_tiposalida = $('#id_tiposalida').val();

        var formData = {
            //id_usuario: id_usuario,
            fecha_salida: fecha_salida,
            hora:hora,
            id_tiposalida: id_tiposalida
           
        };

        $.ajax({
            type: 'POST',
            url: './views/salidas/regsalida.php',
            data: formData,
            dataType: 'html',
            success: function(response) {
                // Limpiar los campos del formulario
                //$('#id_usuario').val('');
                $('#fecha_salida').val('');  
                $('#hora').val('');   
                $('#id_tiposalida').val('');                
                // Actualizar el contenido de DataPanelSalidas
                $("#DataPanelPreSalida").html(response);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        return false;
    });

    $("#BtnPreSalida").click(function() {
        $("#DataPanelPreSalida").load("./views/salidas/presalida.php");
        return false;
    });
});
</script>



