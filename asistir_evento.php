<?php
session_start();

// Verifica si 'usuario_id' está configurado en la sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: iniciar_sesion.php");
    exit;
}

// Configuración de la base de datos
require 'config.php';

$usuario_id = $_SESSION['user_id'];
$evento_id = $_POST['evento_id'];

// Verifica si el usuario ya está registrado para este evento
$checkQuery = "SELECT * FROM solicitud WHERE usuario_id = ? AND evento_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $usuario_id, $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El usuario ya está registrado para este evento
    header("Location: user_menu.php?mensaje=Ya estás registrado para este evento.");
    exit;
} else {
    // Registra al usuario para el evento
    $insertQuery = "INSERT INTO solicitud (usuario_id, evento_id, estado) VALUES (?, ?, 'aprobado')";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $usuario_id, $evento_id);
    $stmt->execute();

    // Incrementa el número de asistentes del evento
    $updateQuery = "UPDATE eventos SET asistentes = asistentes + 1 WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();

    header("Location: user_menu.php?mensaje=Te has registrado para el evento exitosamente.");
    exit;
}
?>
