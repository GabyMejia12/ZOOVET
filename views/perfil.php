<?php
@session_start();
include '../models/conexion.php';
include '../controllers/controllersFunciones.php';
//include '../modal.php';
$conn = conectar_db();

$sql = "SELECT * FROM usuarios";

$result = $conn->query($sql);
$cont = 0;

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
<div  id="DataPanelPerfil">
    

        
</div>
            