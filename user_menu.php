<?php
session_start();

// Verifica si 'user_id' está configurado en la sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: iniciar_sesion.php");
    exit;
}

// Configuración de la base de datos
require 'config.php';

$usuario_id = $_SESSION['user_id'];

// Consulta para obtener la información del usuario
$query = "SELECT u.nombre, u.email, p.telefono, p.tipo, p.matricula, p.correo_institucional, p.direccion
          FROM usuarios u
          LEFT JOIN perfil p ON u.id = p.usuario_id
          WHERE u.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Consulta para obtener los eventos vigentes
$eventQuery = "
    SELECT 
        e.id, 
        e.titulo, 
        e.descripcion, 
        e.fecha_inicio, 
        e.fecha_fin, 
        e.lugar, 
        e.capacidad, 
        (e.capacidad - IFNULL((SELECT COUNT(*) FROM solicitud WHERE evento_id = e.id AND estado = 'aprobado'), 0)) AS capacidad_disponible, 
        e.imagen 
    FROM eventos e 
    WHERE e.fecha_fin >= CURDATE()
    ORDER BY e.fecha_inicio DESC
";
$eventResult = $conn->query($eventQuery);

// Verifica si la consulta fue exitosa
if (!$eventResult) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/Menuuse.css">
</head>
<body>
    <div class="header">
        <img src="imagenes/UTECO.png" alt="Logo">
        <div class="header-right">
            <form action="buscar_evento.php" method="get" class="search-form">
                <input type="text" name="query" placeholder="Buscar eventos...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <a href="inicio.php"><i class="fas fa-home"></i></a>
            <button onclick="toggleProfileMenu()">
                <i class="fas fa-user"></i>
                <br>
            </button>
            <a href="logout.php"><button><i class="fas fa-sign-out-alt"></i></button></a>
            <div class="profile-dropdown">
                <div id="profile-menu" class="profile-menu">
                    <h3>Perfil del Usuario</h3>
                    <form action="actualizar_perfil.php" method="post">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                        
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        
                        <label for="telefono">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>">
                        
                        <label for="tipo">Tipo:</label>
                        <select id="tipo" name="tipo" onchange="toggleAdditionalFields()">
                            <option value="estudiante" <?php if($user['tipo'] == 'estudiante') echo 'selected'; ?>>Estudiante</option>
                            <option value="maestro" <?php if($user['tipo'] == 'maestro') echo 'selected'; ?>>Maestro</option>
                        </select>
                        
                        <div id="matricula-container" class="additional-field" style="display: <?php echo ($user['tipo'] == 'estudiante' ? 'block' : 'none'); ?>;">
                            <label for="matricula">Matrícula:</label>
                            <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($user['matricula']); ?>">
                        </div>
                        
                        <div id="correo-container" class="additional-field" style="display: <?php echo ($user['tipo'] == 'maestro' ? 'block' : 'none'); ?>;">
                            <label for="correo_institucional">Correo Institucional:</label>
                            <input type="email" id="correo_institucional" name="correo_institucional" value="<?php echo htmlspecialchars($user['correo_institucional']); ?>">
                        </div>
                        
                        <label for="direccion">Dirección:</label>
                        <textarea id="direccion" name="direccion"><?php echo htmlspecialchars($user['direccion']); ?></textarea>
                        
                        <button type="submit">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="events">
            <h2>Eventos Recientes</h2>
            <?php while ($event = $eventResult->fetch_assoc()): ?>
                <div class="event">
                    <?php if (!empty($event['imagen'])): ?>
                        <img src="<?php echo htmlspecialchars($event['imagen']); ?>" alt="Imagen del Evento" class="event-image">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($event['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($event['descripcion']); ?></p>
                    <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($event['fecha_inicio']); ?></p>
                    <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($event['fecha_fin']); ?></p>
                    <p><strong>Lugar:</strong> <?php echo htmlspecialchars($event['lugar']); ?></p>
                    <p><strong>Capacidad Disponible:</strong> <?php echo htmlspecialchars($event['capacidad_disponible']); ?></p>
                    <form action="asistir_evento.php" method="post">
                        <input type="hidden" name="evento_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                        <button type="submit" class="btn-asistir">Asistir</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    
    <script>
    function toggleProfileMenu() {
        var menu = document.getElementById('profile-menu');
        menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
    }

    function toggleAdditionalFields() {
        var tipo = document.getElementById('tipo').value;
        document.getElementById('matricula-container').style.display = tipo === 'estudiante' ? 'block' : 'none';
        document.getElementById('correo-container').style.display = tipo === 'maestro' ? 'block' : 'none';
    }
    </script>
</body>
</html>
