<?php
require 'config.php';
session_start();

$usuario_id = $_SESSION['user_id'];

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$tipo = $_POST['tipo'];
$matricula = $_POST['matricula'];
$correo_institucional = $_POST['correo_institucional'];
$direccion = $_POST['direccion'];

// Actualizar la tabla usuarios
$query1 = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("ssi", $nombre, $email, $usuario_id);
$stmt1->execute();

// Verificar si el perfil ya existe
$query2 = "SELECT * FROM perfil WHERE usuario_id = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $usuario_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2->num_rows > 0) {
    // Si el perfil existe, actualizarlo
    $query3 = "UPDATE perfil SET telefono = ?, tipo = ?, matricula = ?, correo_institucional = ?, direccion = ? WHERE usuario_id = ?";
    $stmt3 = $conn->prepare($query3);
    $stmt3->bind_param("sssssi", $telefono, $tipo, $matricula, $correo_institucional, $direccion, $usuario_id);
    $stmt3->execute();
} else {
    // Si el perfil no existe, insertarlo
    $query3 = "INSERT INTO perfil (usuario_id, telefono, tipo, matricula, correo_institucional, direccion) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt3 = $conn->prepare($query3);
    $stmt3->bind_param("isssss", $usuario_id, $telefono, $tipo, $matricula, $correo_institucional, $direccion);
    $stmt3->execute();
}

header("Location: user_menu.php");
?>
