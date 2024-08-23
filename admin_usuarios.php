<?php
include('config.php');

// Procesar formulario de agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, rol, password) VALUES ('$nombre', '$email', '$rol', '$password')";
    mysqli_query($conn, $sql);
}

// Procesar formulario de editar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol', password='$password' WHERE id='$id'";
    } else {
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol' WHERE id='$id'";
    }

    mysqli_query($conn, $sql);
}

// Procesar eliminación de usuario
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM usuarios WHERE id='$id'";
    mysqli_query($conn, $sql);
}

// Obtener usuarios existentes
$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menucss.css">
    <title>Administrar Usuarios</title>
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
    <img src="/imagenes/logo.png" alt="Logo" class="sidebar-logo">
    <ul>
        <li><a href="admin_eventos.php"><i class="fas fa-calendar"></i> Registro de Eventos</a></li>
        <li><a href="admin_asistir.php"><i class="fas fa-users"></i> Solicitudes de Asistencia</a></li>
        <li><a href="admin_usuarios.php"><i class="fas fa-user-cog"></i> Control de Usuarios</a></li>
    </ul>
</div>

    <div class="main-content">
        <h1>Agregar Usuario</h1>
        <form action="admin_usuarios.php" method="post">
            <input type="hidden" name="add_user" value="1">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
            </select>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit"><i class="fas fa-plus"></i> Agregar Usuario</button>
        </form>

        <h1>Usuarios Existentes</h1>
        <table>
            <tr>
                <th><i class="fas fa-user"></i> Nombre</th>
                <th><i class="fas fa-envelope"></i> Email</th>
                <th><i class="fas fa-user-tag"></i> Rol</th>
                <th><i class="fas fa-edit"></i> Acción</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['rol']; ?></td>
                <td>
                    <form action="admin_usuarios.php" method="post" style="display:inline;">
                        <input type="hidden" name="edit_user" value="1">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                        <select name="rol" required>
                            <option value="admin" <?php if ($row['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                            <option value="usuario" <?php if ($row['rol'] == 'usuario') echo 'selected'; ?>>Usuario</option>
                        </select>
                        <input type="password" name="password" placeholder="Nueva contraseña">
                        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
                    </form>
                    <form action="admin_usuarios.php" method="get" style="display:inline;">
                        <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?');"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
