<?php
@session_start();
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
include '../../modal.php';
$conn = conectar_db();

$sql = "SELECT a.fecha_consulta, 
a.RX, a.peso,
b.nombre, b.telefono, 
c.nombre_mascota, c.edad, c.especie, c.raza, c.sexo,
d.nombre AS NombreVeterinario,
d.apellido AS ApellidoVeterinario
FROM consultas AS a 
INNER JOIN mascota AS c ON a.id_mascota = c.id_mascota
INNER JOIN propietario AS b ON c.id_propietario = b.id_propietario
INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario
WHERE a.id_tipoconsulta = 3";

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
                    <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Cirugías</h2>
                    </div>
                    <div class="col-sm-8 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewPet">
                            <i class="material-icons">&#xE147;</i> <span>Regresar</span>
                        </a>
                        <a href="#" class="btn btn-success" id="panel-entradas">
                            <i class="material-icons">&#xE147;</i> <span>Nueva Consulta</span>
                        </a>
                    </div>
                </div>
            </div>
<div class="table-responsive" id="DataPanelMascotas">
    <?php if ($result && $result->num_rows > 0) : ?>
        <table class="table table-striped" style="margin: 0 auto; width: 80%">
            <thead style="vertical-align: middle; text-align: center;">
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Propietario</th>
                    <th>Teléfono</th>
                    <th>Mascota</th>
                    <th>Sexo</th>
                    <th>Raza</th>
                    <th>Peso</th>
                    <th>RX</th>
                    <th>MV</th>
                </tr>
            </thead>
            <tbody style="vertical-align: middle; text-align: center;">
                <?php foreach ($result as $data) : ?>
                    

                    <tr>
                        <td><?php echo ++$cont; ?></td>
                        <td><?php echo $data['fecha_consulta']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['telefono']; ?></td>
                        <td><?php echo $data['nombre_mascota']; ?></td>
                        <td><?php echo $data['sexo']; ?></td>
                        <td><?php echo $data['raza']; ?></td>
                        <td><?php echo $data['peso']; ?></td>
                        <td><?php echo $data['RX']; ?></td>                        
                        <td><?php echo $data['NombreVeterinario']." ".$data['ApellidoVeterinario']; ?></td>                        
                         
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
        $("#panel-entradas").click(function() {
            $("#sub-data").load("./views/consultas/cirugias/nueva_consulta.php");
            return false;
        });
    });
</script>