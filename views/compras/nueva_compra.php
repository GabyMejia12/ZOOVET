<?php
@session_start();
date_default_timezone_set('America/El_Salvador');
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';

$conn = conectar_db();
$id_usuario = $_SESSION['idusuario'];


// Consulta para obtener solo la información del usuario
$sql = "SELECT *
        FROM usuarios u 
        WHERE u.id_usuario = '$id_usuario'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_usuario = $row['id_usuario'];
$nombre = $row['nombre'];
$apellido = $row['apellido'];
$usuario = $row['usuario'];
$tipo = $row['tipo'];

$comprasEstado0="SELECT COUNT(*) AS tentradas FROM entrada WHERE  estado =0 AND id_usuario='$id_usuario'";
$result = $conn->query($comprasEstado0);
$row = $result->fetch_assoc();
$tentradas = $row['tentradas'];
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
                                <a href="" style="float: right;" class="btn btn-outline-warning" id="BtnPreventa"><i class="fa-solid fa-cart-shopping"></i> <?php echo $tentradas; ?></a>
                            <?php endif ?>
                        </div>
                        <div class="card-body text-info">
                            <h5 class="card-title">Datos del Usuario</h5>
                            <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>">
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
                                    <span class="input-group-text" id="basic-addon1">Fecha y hora</span>
                                </div>
                                <input type="text" class="form-control" aria-describedby="basic-addon1" id="fecha" name="fecha" value="<?php echo $fecha_actual; ?>" readonly><br>
                            </div>  
                            <!-- Botón para registrar entrada-->
                            <div class="input-group mb-3">
                                <button type="button" id="ActualizarContraseña" class="btn btn-outline-info">Registrar Productos</button>
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
                
                <div id="DataPanelCompras">
                    <div class="card border-info text-white mb-9" style="width: 50rem;">
                    <div class="card-header bg-info border-info">
                            Registrar productos 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div> 
</div>



