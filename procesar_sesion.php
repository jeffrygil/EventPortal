<?php
session_start();
require 'config.php'; // Asegúrate de que este archivo tenga los datos de conexión a la base de datos

$email = $_POST['email'];
$password = $_POST['password'];

// Depurar datos recibidos (asegúrate de eliminar estas líneas en producción)
error_log("Email: $email");
error_log("Password: $password");

// Consulta para verificar las credenciales del usuario
$query = "SELECT id, password, rol FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Verificar si el usuario existe
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password, $rol);
    $stmt->fetch();

    // Verificar la contraseña usando password_verify
    if (password_verify($password, $hashed_password)) {
        // Establecer la sesión del usuario
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $rol;

        // Redirigir según el rol del usuario
        if ($rol == 'admin') {
            header('Location: admin_menu.php');
        } else {
            header('Location: inicio.php');
        }
        exit();
    } else {
        error_log("Contraseña incorrecta");
        header('Location: iniciar_sesion.php?error=1');
        exit();
    }
} else {
    error_log("Email no encontrado");
    header('Location: iniciar_sesion.php?error=1');
    exit();
}
?>
