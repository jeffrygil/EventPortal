<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menucss.css">
    <title>Admin Menu</title>
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
        </div></div>

    <div class="sidebar">
        <ul>
            <li><a href="admin_eventos.php"><i class="fas fa-calendar"></i> Registro de Eventos</a></li>
            <li><a href="admin_asistir.php"><i class="fas fa-users"></i> Solicitudes de Asistencia</a></li>
            <li><a href="admin_usuarios.php"><i class="fas fa-user-cog"></i> Control de Usuarios</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Bienvenido al Panel de Administración</h1>
        <p>Aquí puedes gestionar los eventos, ver las solicitudes de asistencia y controlar los usuarios.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
