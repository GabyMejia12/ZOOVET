<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
include '../modal.php';
$conn = conectar_db();

$cont = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'] ?? '';
    $panel = $_POST['panel'] ?? '';

    $resultados = '';

    if ($panel === 'DataPanelCitas') {
        // Consulta de búsqueda
        $sql = "SELECT a.id_cita, a.fecha, a.hora, b.codigo_mascota, b.nombre_mascota, c.nombre 
                FROM cita AS a 
                INNER JOIN mascota AS b ON a.id_mascota = b.id_mascota
                INNER JOIN veterinario AS c ON a.id_veterinario = c.id_veterinario
                WHERE b.nombre_mascota LIKE ? OR b.codigo_mascota LIKE ?";
        $stmt = $conn->prepare($sql);
        $param = "%$query%";
        $stmt->bind_param("ss", $param, $param);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Comenzamos la tabla
            $resultados .= "<table class='table table-bordered table-hover table-borderless' style='margin: 0 auto; width: 100%'>
                                <thead style='vertical-align: middle; text-align: center;'>
                                    <tr>
                                        <th>N°</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Código Mascota</th>
                                        <th>Nombre Mascota</th>
                                        <th>Veterinario</th>
                                        <th colspan='2'>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style='vertical-align: middle; text-align: center;'>";
            
            // Rellenamos la tabla con los datos de cada mascota
            while ($row = $result->fetch_assoc()) {
             

                $resultados .= "<tr>
                                    <td>" . ++$cont . "</td>
                                    <td>" . htmlspecialchars($row['fecha']) . "</td>
                                    <td>" . htmlspecialchars($row['hora']) . "</td>
                                    <td>" . htmlspecialchars($row['codigo_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>
                                        <a href='' class='btn text-white BtnUpdateCita' id_cita='" . htmlspecialchars($row['id_cita']) . "' style='background-color: #078E10;'>
                                            <i class='fa-solid fa-user-pen'></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href='' class='btn text-white BtnDelCita' id_cita='" . htmlspecialchars($row['id_cita']) . "' style='background-color: #031A58;'>
                                            <i class='fa-solid fa-user-xmark'></i>
                                        </a>
                                    </td>
                                    <td>";
                
                
                $resultados .= "</td></tr>";
            }

            $resultados .= "</tbody></table>";
        } else {
            $resultados = "<p>No se encontraron resultados para '$query'.</p>";
        }
    }

    echo $resultados;
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Incluye Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Incluye Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    //Boton actualizar
    $(".BtnUpdateCita").click(function() {
            let id_cita = $(this).attr("id_cita");
            $("#ModalPrincipal").modal("show");
            $('#DataEfectosModal').addClass('modal-dialog modal-dialog-centered modal-dialog-scrollable');
            document.getElementById("DataTituloModal").innerHTML = 'Actualizar información de cita';
            $("#DataModalPrincipal").load("./views/citas/form_update.php?id_cita=" + id_cita);
            $('#ProcesoBotonModal').css('display', 'none');
            $('#ProcesoBotonModal2').css('display', 'block');
            document.getElementById("TituloBotonModal2").innerHTML = 'Actualizar';
            return false;
        });
        // Proceso Update
        $("#ProcesoBotonModal2").click(function() {
            if ($('#fecha').val() === '' || $('#hora').val() === '' || $('#id_mascota').val() === '' || $('#id_veterinario').val() === '') {
                //alert('Por favor completa todos los campos.');
                return;
            }
            let id_cita,fecha, hora, id_mascota, id_veterinario;
            id_cita = $('#id_cita').val();
            fecha = $('#fecha').val();
            hora = $('#hora').val();
            id_mascota = $('#id_mascota').val();
            id_veterinario = $('#id_veterinario').val();

            var formData = {
                id_cita: id_cita,
                fecha: fecha,
                hora: hora,
                id_mascota: id_mascota,
                id_veterinario: id_veterinario
            };
            $.ajax({
                type: 'POST',
                url: './views/citas/update.php',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $("#ModalPrincipal").modal("hide");
                    $('#fecha').val('');
                    $('#hora').val('');
                    $('#id_mascota').val('');
                    $('#id_veterinario').val('');
                    $("#DataPanelCitas").html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });
        // Proceso Delete
$(document).ready(function() {
            $('.BtnDelCita').click(function() {
                let id_cita = $(this).attr('id_cita');

                Swal.fire({
                    title: '¿Desea eliminar la cita?',
                    text: "¡Esta acción no se puede deshacer!",
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
                            url: './views/citas/del.php',
                            data: { id_cita: id_cita },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado',
                                    'La cita ha sido eliminada.',
                                    'success'
                                );
                                $("#DataPanelCitas").html(response);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al eliminar la cita',
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


</script>