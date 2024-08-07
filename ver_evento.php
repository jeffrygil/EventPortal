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
            <a href="user_menu.php"><i class="fas fa-home"></i> Inicio</a>
            <div class="profile-dropdown">
                <button onclick="toggleProfileMenu()"><i class="fas fa-user"></i> Perfil</button>
                <div id="profile-menu" class="profile-menu">
                    <h3>Perfil del Usuario</h3>
                    <?php
                    require 'config.php';
                    session_start();
                    $usuario_id = $_SESSION['user_id'];
                    $query = "SELECT u.nombre, u.email, p.telefono, p.tipo, p.matricula, p.correo_institucional, p.direccion
                              FROM usuarios u
                              LEFT JOIN perfil p ON u.id = p.usuario_id
                              WHERE u.id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $usuario_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    ?>
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
            <?php
            // Obtener los eventos
            $query = "SELECT id, titulo, descripcion, fecha FROM eventos ORDER BY fecha DESC";
            $result = $conn->query($query);
            while ($event = $result->fetch_assoc()) {
                echo '<div class="event">';
                echo '<h3>' . htmlspecialchars($event['titulo']) . '</h3>';
                echo '<p>' . htmlspecialchars($event['descripcion']) . '</p>';
                echo '<p><strong>Fecha:</strong> ' . htmlspecialchars($event['fecha']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="filters">
            <h2>Filtrar Eventos</h2>
            <form action="user_menu.php" method="get">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas</option>
                    <!-- Añade aquí las categorías -->
                </select>
                <button type="submit">Filtrar</button>
            </form>
        </div>
    </div>
    
    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        function toggleAdditionalFields() {
            const tipo = document.getElementById('tipo').value;
            document.getElementById('matricula-container').style.display = tipo === 'estudiante' ? 'block' : 'none';
            document.getElementById('correo-container').style.display = tipo === 'maestro' ? 'block' : 'none';
        }
    </script>
</body>
</html>
