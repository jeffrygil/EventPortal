<?php
include('config.php');

$usuario_id = $_POST['usuario_id'];
$evento_id = $_POST['evento_id'];
$tipo = $_POST['tipo'];
$estado = 'pendiente'; // Estado inicial de la solicitud

// Inserta los datos en la base de datos
$sql = "INSERT INTO solicitudes (usuario_id, evento_id, tipo, estado) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $usuario_id, $evento_id, $tipo, $estado);

if ($stmt->execute()) {
    echo "Solicitud registrada exitosamente";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
