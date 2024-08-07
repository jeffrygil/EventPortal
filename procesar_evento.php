<?php
session_start();
include('config.php');

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];
$lugar = $_POST['lugar'];

$imagen = $_FILES['imagen'];
$imagenPath = '';

if ($imagen && $imagen['tmp_name']) {
    $imagenPath = 'uploads/' . basename($imagen['name']);
    move_uploaded_file($imagen['tmp_name'], $imagenPath);
}

$sql = "INSERT INTO eventos (titulo, descripcion, fecha, lugar, imagen) VALUES ('$titulo', '$descripcion', '$fecha', '$lugar', '$imagenPath')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Evento registrado exitosamente.'); window.location.href='proximo_evento.php';</script>";
} else {
    echo "<script>alert('Error al registrar el evento. Por favor, inténtelo de nuevo.'); window.location.href='registrar_evento.php';</script>";
}

mysqli_close($conn);
?>
