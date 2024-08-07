<?php
include('config.php');

// Procesar formulario de agregar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Subir imagen
    $imagen = $_FILES['imagen']['name'];
    $target_dir = "uploads/";

    // Verificar si la carpeta 'uploads' existe, si no, crearla
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($imagen);
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin, imagen) VALUES ('$titulo', '$descripcion', '$fecha_inicio', '$fecha_fin', '$target_file')";
        mysqli_query($conn, $sql);
    } else {
        echo "Error al subir la imagen.";
    }
}

// Obtener eventos existentes
$sql = "SELECT * FROM eventos";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menucss.css">
    <title>Administrar Eventos</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <div class="header-right">
            <ul>
                <li><a href="admin_menu.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="admin_eventos.php"><i class="fas fa-calendar"></i> Eventos</a></li>
                <li><a href="admin_asistir.php"><i class="fas fa-users"></i> Asistir</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="admin_eventos.php"><i class="fas fa-calendar"></i> Registro de Eventos</a></li>
            <li><a href="admin_asistir.php"><i class="fas fa-users"></i> Solicitudes de Asistencia</a></li>
            <li><a href="admin_usuarios.php"><i class="fas fa-user-cog"></i> Control de Usuarios</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Agregar Evento</h1>
        <form action="admin_eventos.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <label for="imagen">Imagen del Evento:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" required>

            <button type="submit"><i class="fas fa-plus"></i> Agregar Evento</button>
        </form>

        <h1>Eventos Existentes</h1>
        <table>
            <tr>
                <th><i class="fas fa-calendar-alt"></i> Título</th>
                <th><i class="fas fa-align-left"></i> Descripción</th>
                <th><i class="fas fa-clock"></i> Fecha de Inicio</th>
                <th><i class="fas fa-clock"></i> Fecha de Fin</th>
                <th><i class="fas fa-image"></i> Imagen</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha_fin']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen del Evento" style="width:100px;"></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
