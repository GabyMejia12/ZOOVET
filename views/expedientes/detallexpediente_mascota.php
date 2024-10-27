<!-- detalle_expediente.php -->
<?php
// Conectar a la base de datos
$id_mascota = $_GET['id_mascota'];

// Obtener la información de la mascota
$mascota = "SELECT * ";// consulta para obtener datos de la mascota específica por su id

// Obtener el historial de consultas
$consultas = // consulta para obtener las consultas ordenadas por fecha ascendente (más antigua a más reciente)
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expediente de <?php echo $mascota['nombre_mascota']; ?></title>
</head>
<body>
    <h1>Expediente de <?php echo $mascota['nombre_mascota']; ?></h1>
    <p>Especie: <?php echo $mascota['especie']; ?></p>
    <p>Raza: <?php echo $mascota['raza']; ?></p>
    <p>Edad: <?php echo $mascota['edad']; ?> años</p>

    <hr>
    <h2>Historial de Consultas</h2>

    <?php foreach ($consultas as $consulta): ?>
        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
            <p><strong>Fecha:</strong> <?php echo $consulta['fecha_consulta']; ?></p>
            <p><strong>Motivo:</strong> <?php echo $consulta['RX']; ?></p>
            <p><strong>Peso:</strong> <?php echo $consulta['peso']; ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
