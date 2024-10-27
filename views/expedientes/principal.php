<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$sql = "SELECT a.fecha_consulta, 
a.RX, a.id_tipoconsulta, a.peso,
b.nombre, b.telefono, 
c.nombre_mascota, c.edad, c.especie, c.raza, c.sexo,c.codigo_mascota,
d.nombre AS NombreVeterinario,
d.apellido AS ApellidoVeterinario,
e.nombre_consulta
FROM consultas AS a 
INNER JOIN mascota AS c ON a.id_mascota = c.id_mascota
INNER JOIN propietario AS b ON c.id_propietario = b.id_propietario
INNER JOIN usuarios as d ON d.id_usuario = a.id_veterinario
INNER JOIN tipo_consulta AS e ON a.id_tipoconsulta = e.id_tipoconsulta"
;

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

<form id="searchForm">
    <input type="date" id="fechaInicio" name="fechaInicio" required>
    <input type="date" id="fechaFin" name="fechaFin" required>
    <input type="text" id="nombreMascota" name="nombreMascota" placeholder="Nombre de la mascota">
    <button type="submit">Buscar</button>
</form>

<div id="resultados"></div>

<div>
<div class="row">
    <div class="col-md-12">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4 p-0 flex justify-content-lg-start justify-content-center">
                        <h2 class="ml-lg-2">Consultas generales</h2>
                    </div>
                    <div class="col-sm-8 p-0 d-flex justify-content-lg-end justify-content-center">
                        <a href="#" class="btn btn-success" id="BtnNewPet">
                            <i class="material-icons">&#xE147;</i> <span>Regresar</span>
                        </a>
                        <a href="#" class="btn btn-success" id="BtnNewConG">
                            <i class="material-icons">&#xE147;</i> <span>Nueva Consulta</span>
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
                    <th>Fecha</th>
                    <th>Propietario</th>
                    <th>Teléfono</th>
                    <th>Código Mascota</th>
                    <th>Mascota</th>
                    <th>Sexo</th>
                    <th>Raza</th>
                    <th>Peso</th>
                    <th>RX</th>
                    <th>Tipo Consulta</th>
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
                        <td><?php echo $data['codigo_mascota']; ?></td>
                        <td><?php echo $data['nombre_mascota']; ?></td>
                        <td><?php echo $data['sexo']; ?></td>
                        <td><?php echo $data['raza']; ?></td>
                        <td><?php echo $data['peso']; ?></td>
                        <td><?php echo $data['RX']; ?></td>   
                        <td><?php echo $data['nombre_consulta']; ?></td>                     
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
        //
        $("#BtnNewConG").click(function() {
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Nueva consulta';
            $("#DataModalPrincipal").load("./views/consultas/general/form_insert.php");  
            $('#ProcesoBotonModal').css('display', 'block');
            $('#ProcesoBotonModal2').css('display', 'none');
            document.getElementById("TituloBotonModal").innerHTML = 'Guardar';
            return false;
        });


        // Proceso Insert
        $("#ProcesoBotonModal").click(function() {


            if ($('#RX').val() === '' || $('#fecha_consulta').val() === '' || $('#peso').val() === '' || $('#id_tipoconsulta').val() === '' || $('#id_veterinario').val() === '' || $('#id_mascota').val() === '' || $('#id_usuario').val() === '') {
                alert('Por favor completa todos los campos.');
                return;
            }
            let RX, fecha_consulta, peso, id_tipoconsulta, id_veterinario, id_mascota, id_usuario;
            RX = $('#RX').val();
            fecha_consulta = $('#fecha_consulta').val();
            peso = $('#peso').val();
            id_tipoconsulta = $('#id_tipoconsulta').val();
            id_veterinario = $('#id_veterinario').val();
            id_mascota = $('#id_mascota').val();
            id_usuario = $('#id_usuario').val();
            medicamentos = [];
                $('.medicamento').each(function() {
                    let medicamento_id = $(this).find('.medicamento-id').val();
                    let cantidad = $(this).find('.cantidad').val();

                    medicamentos.push({ id_producto: medicamento_id, cantidad_detsalida: cantidad });
                });

            var formData = {
                RX: RX,
                fecha_consulta: fecha_consulta,
                peso: peso,
                id_tipoconsulta: id_tipoconsulta,
                id_veterinario: id_veterinario,
                id_mascota: id_mascota,
                id_usuario: id_usuario,
                medicamentos: medicamentos
            };
            $.ajax({
                type: 'POST',
                url: './views/consultas/general/insertPrueba.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#RX').val('');
                    $('#fecha_consulta').val('');
                    $('#peso').val('');
                    $('#id_tipoconsulta').val('');
                    $('#id_veterinario').val('');
                    $('#id_mascota').val('');
                    $('#id_usuario').val('');
                    $('#medicamentos').val('');
                    $("#DataPanelMascotas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });


    });

    document.getElementById('searchForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const nombreMascota = document.getElementById('nombreMascota').value;

    const response = await fetch(`./views/expedientes/getConsultas.php?fechaInicio=${fechaInicio}&fechaFin=${fechaFin}&nombreMascota=${nombreMascota}`);
    const expedientes = await response.json();

    const resultadosDiv = document.getElementById('resultados');
    resultadosDiv.innerHTML = expedientes.map(exp => `
        <p>Expediente: ${exp['nombre_expediente']} - Fecha: ${exp['fecha_creacion']} - Mascota: ${exp['nombre_mascota']} (Raza: ${exp['raza']})</p>
    `).join('');
});


</script>