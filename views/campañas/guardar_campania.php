<?php
session_start();
header('Content-Type: application/json'); // Establecer el tipo de contenido

include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Conexión fallida: " . $conn->connect_error]);
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Obtener y validar datos
        $nombre_propietario = $_POST['nombre_propietario'];
        $telefono = $_POST['telefono'];
        $nombre_mascota = $_POST['nombre_mascota'];
        $peso = $_POST['peso'];
        $id_tipoconsulta = $_POST['id_tipoconsulta'];
        $RX = $_POST['RX'];
        $id_veterinario = $_POST['id_veterinario'];
        $id_usuario = $_POST['id_usuario'];
        $id_tiposalida = 3; // Cambia esto según tu lógica
        $estado = 1; // Cambia esto según tu lógica

        

        // Insertar en campañas
        $stmt = $conn->prepare("INSERT INTO campañas (nombre_propietario, telefono, nombre_mascota, peso, id_tipoconsulta, RX, id_veterinario, fecha_campaña)
                                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssssi", $nombre_propietario, $telefono, $nombre_mascota, $peso, $id_tipoconsulta, $RX, $id_veterinario);
        $stmt->execute();
        $id_campaña = $conn->insert_id;
        $stmt->close();

        // Insertar en salidas
        $stmt = $conn->prepare("INSERT INTO salida (fecha_salida, id_tiposalida, id_usuario, id_consulta, estado) VALUES (NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("iisi", $id_tiposalida, $id_usuario, $id_campaña, $estado);
        $stmt->execute();
        $id_salida = $conn->insert_id;
        $stmt->close();

        // Registrar medicamentos
        $medicamentos = $_POST['medicamentos'];
        foreach ($medicamentos as $medicamento) {
            $id_producto = $medicamento['id_producto'];
            $cantidad_detsalida = $medicamento['cantidad_detsalida'];
            $precio_salida = $medicamento['precio_compra'];

            // Insertar en detalle_salida
            $stmt = $conn->prepare("INSERT INTO detalle_salida (cantidad_detsalida, precio_salida,id_salida, id_producto,estado) VALUES (?, ?,?,?, ?)");
            $stmt->bind_param("isiii", $cantidad_detsalida,$precio_salida, $id_salida, $id_producto, $estado);
            $stmt->execute();
            $stmt->close();

            // 4. Actualizar el stock de los productos
            $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
            $stmt->bind_param("ii", $cantidad_detsalida, $id_producto);
            $stmt->execute();
            $stmt->close();
        }

        // Confirmar transacción
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => 'Campaña y salidas registradas correctamente',
            
        ]);
    } catch (Exception $e) {
        // Manejar errores y revertir transacciones
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al registrar los datos: ' . $e->getMessage()]);
    }
}
?>
