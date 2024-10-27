<?php
session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

$id_mascota = $_GET['id_mascota'];
$fecha_inicio = $_GET['fecha_inicio'] ?? null;
$fecha_fin = $_GET['fecha_fin'] ?? null;

// Consulta para obtener la información básica de la mascota
$stmt = $conn->prepare("SELECT codigo_mascota, nombre_mascota, especie, raza, sexo FROM mascota WHERE id_mascota = ?");
$stmt->bind_param("i", $id_mascota);
$stmt->execute();
$result_mascota = $stmt->get_result();

 // consulta para obtener las consultas ordenadas por fecha ascendente (más antigua a más reciente)
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expediente de <?php echo htmlspecialchars($mascota['nombre_mascota']); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Información estática de la mascota -->
    <h1>Expediente de <?php echo htmlspecialchars($mascota['nombre_mascota']); ?></h1>
    <p>Especie: <?php echo htmlspecialchars($mascota['especie']); ?></p>
    <p>Raza: <?php echo htmlspecialchars($mascota['raza']); ?></p>
    <p>Sexo: <?php echo htmlspecialchars($mascota['sexo']); ?></p>

    <hr>
    <h2>Filtrar Historial de Consultas</h2>
    <!-- Formulario para seleccionar rango de fechas -->
    <form id="filterForm">
        <input type="hidden" name="id_mascota" value="<?php echo htmlspecialchars($id_mascota); ?>">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" id="fecha_inicio" required>
        
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" id="fecha_fin" required>
        
        <button type="button" id="BtnFiltrar">Filtrar</button>
    </form>

    <hr>
    <h2>Historial de Consultas</h2>
    <div id="DataPanelDetExp">
        <?php if (count($consultas) > 0): ?>
            <?php foreach ($consultas as $consulta): ?>
                <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($consulta['fecha_consulta']); ?></p>
                    <p><strong>Motivo:</strong> <?php echo htmlspecialchars($consulta['RX']); ?></p>
                    <p><strong>Peso:</strong> <?php echo htmlspecialchars($consulta['peso']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron consultas para esta mascota.</p>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function() {
            $("#BtnFiltrar").click(function() {
                var id_mascota = $("input[name='id_mascota']").val();
                var fecha_inicio = $("#fecha_inicio").val();
                var fecha_fin = $("#fecha_fin").val();

                if (!fecha_inicio || !fecha_fin) {
                    alert("Por favor selecciona ambas fechas.");
                    return;
                }

                // Enviar solicitud AJAX para actualizar solo el historial de consultas
                $.ajax({
                    url: "./views/expedientes/detallexpediente_mascota.php",
                    type: "GET",
                    data: {
                        id_mascota: id_mascota,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        ajax: "true"
                    },
                    success: function(response) {
                        $("#DataPanelDetExp").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al cargar el historial:", xhr, status, error);
                        alert("Error al cargar el historial de consultas.");
                    }
                });
            });
        });
    </script>
</body>
</html>
