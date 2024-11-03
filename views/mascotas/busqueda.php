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

    if ($panel === 'DataPanelMascotas') {
        // Consulta de búsqueda
        $sql = "SELECT b.nombre, b.telefono, a.id_mascota, a.nombre_mascota, a.peso, a.edad, a.especie, a.sexo, a.raza, a.estado 
                FROM mascota AS a 
                INNER JOIN propietario AS b ON a.id_propietario = b.id_propietario
                WHERE a.nombre_mascota LIKE ? OR a.codigo_mascota LIKE ?";
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
                                        <th>Propietario</th>
                                        <th>Teléfono</th>
                                        <th>Nombre Mascota</th>
                                        <th>Peso</th>
                                        <th>Edad</th>
                                        <th>Especie</th>
                                        <th>Sexo</th>
                                        <th>Raza</th>
                                        <th>Estado</th>
                                        <th colspan='2'>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style='vertical-align: middle; text-align: center;'>";
            
            // Rellenamos la tabla con los datos de cada mascota
            while ($row = $result->fetch_assoc()) {
                $estadoColor = $row['estado'] == 1 ? 'green' : 'red';
                $estadoTexto = $row['estado'] == 1 ? 'Activo' : 'Inactivo';

                $resultados .= "<tr>
                                    <td>" . ++$cont . "</td>
                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                    <td>" . htmlspecialchars($row['telefono']) . "</td>
                                    <td>" . htmlspecialchars($row['nombre_mascota']) . "</td>
                                    <td>" . htmlspecialchars($row['peso']) . "</td>
                                    <td>" . htmlspecialchars($row['edad']) . "</td>
                                    <td>" . htmlspecialchars($row['especie']) . "</td>
                                    <td>" . htmlspecialchars($row['sexo']) . "</td>
                                    <td>" . htmlspecialchars($row['raza']) . "</td>
                                    <td><b style='color: $estadoColor;'>$estadoTexto</b></td>
                                    <td>
                                        <a href='' class='btn text-white BtnUpdateMascota' id_mascota='" . htmlspecialchars($row['id_mascota']) . "' style='background-color: #9fd86b;'>
                                            <i class='fa-solid fa-user-pen'></i>
                                        </a>
                                    </td>
                                    <td>";
                
                // Agregar botón de estado
                if ($row['estado'] == 1) {
                    $resultados .= "<a href='' class='btn text-white BtnUpdateEstado' style='background-color: #ff6666;' id_mascota='" . htmlspecialchars($row['id_mascota']) . "' estado='1'>
                                        <i class='fa-solid fa-ban'></i>
                                    </a>";
                } else {
                    $resultados .= "<a href='' class='btn text-white BtnUpdateEstado' style='background-color: #003366;' id_mascota='" . htmlspecialchars($row['id_mascota']) . "' estado='0'>
                                        <i class='fa-solid fa-check'></i>
                                    </a>";
                }
                
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
</script>