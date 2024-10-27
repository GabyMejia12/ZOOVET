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


$comprasEstado0="SELECT COUNT(*) AS tentradas FROM entrada WHERE  estado =0 AND id_usuario='$id_usuario'";
$result1 = $conn->query($comprasEstado0);
$row1 = $result1->fetch_assoc();
$tentradas = $row1['tentradas'];
// Obtener la fecha y hora actual del sistema
$fecha_actual = date("Y-m-d H:i:s");

?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Compras</h2>
                        </div>
                    </div>
                </div>
                <div id="DataPanelPerfil">
                    <br>
                    <div class="card border-info text-white mb-6" style="width: 50rem;">
                        <div class="card-header bg-info border-info">
                            Registrar compra 
                            <?php if ($tentradas == 0) : ?>
                                <a href="" style="float: right;" class="btn btn-outline-warning bloqueado" disabled><i class="fa-solid fa-cart-shopping"></i> <?php echo $tentradas; ?></a>
                            <?php else : ?>
                                <a href="" style="float: right;" class="btn btn-outline-warning" id="BtnPreCompra"><i class="fa-solid fa-cart-shopping"></i> <?php echo $tentradas; ?></a>
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
                                <span class="input-group-text" id="basic-addon1"><b>Fecha</b></span>
                                
                                <input type="text" class="form-control" placeholder="" name="fecha" id="fecha" value="<?php echo $fecha_actual?>" readonly>
                                </div>
                                 
                            <!-- Botón para registrar entrada-->
                            <div class="input-group mb-3">
                                <button type="button" id="BtnReg-Compra" class="btn btn-outline-info">Procesar compra</button>
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
                <div id="DataPanelPreCompra">
                    
                </div>
            </div>
        </div>
   </div> 
</div>
<script>
    $(document).ready(function() {
        $("#BtnReg-Compra").click(function() {
            // Verificar que todos los campos requeridos no estén vacíos
            if (//$('#id_usuario').val() === '' ||
                $('#fecha').val() === '',
                $('#hora').val() === ''
                ) {
                alert('Por favor ingrese todos los datos de compra');
                return;
            }

            // Obtener los valores de los campos
            //let id_usuario = $('#id_usuario').val();
            let fecha = $('#fecha').val();
            let hora = $('#hora').val();

            var formData = {
                //id_usuario: id_usuario,
                fecha: fecha,
                hora:hora
               
            };

            $.ajax({
                type: 'POST',
                url: './views/compras/regcompra.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    // Limpiar los campos del formulario
                    //$('#id_usuario').val('');
                    $('#fecha').val('');  
                    $('#hora').val('');                  
                    // Actualizar el contenido de DataPanelCompras
                    $("#DataPanelPreCompra").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });

        $("#BtnPreCompra").click(function() {
            $("#DataPanelPreCompra").load("./views/compras/precompra.php");
            return false;
        });
    });
</script>



