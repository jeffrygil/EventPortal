<?php
session_start();
include('config.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

// Verificar si el usuario ya está registrado
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // El usuario ya está registrado
    echo "<script>alert('El email ya está registrado.'); window.location.href='registrarse.php';</script>";
} else {
    // Insertar nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registro exitoso.'); window.location.href='iniciar_sesion.php';</script>";
    } else {
        echo "<script>alert('Error al registrar. Por favor, inténtelo de nuevo.'); window.location.href='registrarse.php';</script>";
    }
}

mysqli_close($conn);
?>
