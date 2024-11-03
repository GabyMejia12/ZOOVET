<?php
session_start();
include '../../../models/conexion.php';
include '../../../controllers/controllersFunciones.php';
$conn = conectar_db();

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Iniciar una transacción
    $conn->begin_transaction();

    try {

        $codigo_mascota = $_POST['codigo_mascota'];

        // 1. Obtener el ID de la mascota a partir del nombre
        $stmt = $conn->prepare("SELECT id_mascota FROM mascota WHERE codigo_mascota = ?");
        $stmt->bind_param("s", $codigo_mascota);
        $stmt->execute();
        $stmt->bind_result($id_mascota);
        $stmt->fetch();
        $stmt->close();

        // Verificar si se encontró la mascota
        if (!$id_mascota) {
            throw new Exception("No se encontró la mascota con el nombre proporcionado.");
        }

        // 1. Registrar la consulta médica
        $RX = $_POST['RX'];
        $id_tipoconsulta = $_POST['id_tipoconsulta'];
        $peso = $_POST['peso'];
        $id_veterinario = $_POST['id_veterinario'];
        $id_tiposalida = 1;
        $id_usuario = $_POST['id_usuario'];
        $estado = 1;

        $stmt = $conn->prepare("INSERT INTO consultas (RX, fecha_consulta, peso, id_tipoconsulta, id_veterinario, id_mascota) VALUES (?, NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $RX, $peso, $id_tipoconsulta, $id_veterinario, $id_mascota);
        $stmt->execute();
        $id_consulta = $conn->insert_id;
        $stmt->close();

        // 2. Registrar en la tabla salidas
        $stmt = $conn->prepare("INSERT INTO salida (fecha_salida, id_tiposalida, id_usuario, id_consulta, estado) VALUES ( NOW(), ?, ?, ?, ?)");
        $stmt->bind_param("iiii", $id_tiposalida, $id_usuario, $id_consulta, $estado);
        $stmt->execute();
        $id_salida = $conn->insert_id;
        $stmt->close();

        // 3. Registrar los medicamentos en la tabla detalle_salida
        $medicamentos = $_POST['medicamentos']; // Array de medicamentos y cantidades
        foreach ($medicamentos as $medicamento) {
            $id_producto = $medicamento['id_producto'];
            $cantidad_detsalida = $medicamento['cantidad_detsalida'];
            $precio_salida = $medicamento['precio_compra'];

            // Insertar en detalle_salida
            $stmt = $conn->prepare("INSERT INTO detalle_salida (cantidad_detsalida, precio_salida,  id_salida, id_producto, estado) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isiii", $cantidad_detsalida, $precio_salida, $id_salida, $id_producto, $estado);
            $stmt->execute();
            $stmt->close();
            

            // 4. Actualizar el stock de los productos
            $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
            $stmt->bind_param("ii", $cantidad_detsalida, $id_producto);
            $stmt->execute();
            $stmt->close();
        }

        // Si todo se ejecuta bien, confirmar la transacción
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Consulta y salidas registradas correctamente']);
    } catch (Exception $e) {
        // Si ocurre un error, deshacer la transacción
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al registrar los datos: ' . $e->getMessage()]);
    }
}
?>
