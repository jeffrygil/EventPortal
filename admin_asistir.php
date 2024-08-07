<?php
include('config.php');

$sql = "SELECT s.id, u.nombre, e.titulo, s.fecha_solicitud, s.estado, s.usuario_id, s.evento_id, u.tipo
        FROM solicitudes s
        JOIN usuarios u ON s.usuario_id = u.id
        JOIN eventos e ON s.evento_id = e.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menucss.css">
    <title>Administrar Solicitudes</title>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="header">
        <img src="UTECO.png" alt="Logo">
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
        <h1>Solicitudes de Asistencia</h1>
        <table>
            <tr>
                <th><i class="fas fa-user"></i> Nombre</th>
                <th><i class="fas fa-calendar-alt"></i> Evento</th>
                <th><i class="fas fa-clock"></i> Fecha de Solicitud</th>
                <th><i class="fas fa-info-circle"></i> Estado</th>
                <th><i class="fas fa-user-graduate"></i> Tipo</th> <!-- Nueva columna para tipo -->
                <th><i class="fas fa-edit"></i> Acción</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha_solicitud']); ?></td>
                <td><?php echo htmlspecialchars($row['estado']); ?></td>
                <td><?php echo htmlspecialchars($row['tipo']); ?></td> <!-- Mostrar el tipo -->
                <td>
                    <form action="procesar_solicitudes.php" method="post">
                        <input type="hidden" name="solicitud_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($row['usuario_id']); ?>">
                        <input type="hidden" name="evento_id" value="<?php echo htmlspecialchars($row['evento_id']); ?>">
                        <select name="estado">
                            <option value="pendiente" <?php if ($row['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                            <option value="aprobado" <?php if ($row['estado'] == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                            <option value="rechazado" <?php if ($row['estado'] == 'rechazado') echo 'selected'; ?>>Rechazado</option>
                        </select>
                        <button type="submit"><i class="fas fa-check"></i> Actualizar</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
