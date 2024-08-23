<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Eventos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <img src="imagenes/UTECO.png" alt="Logo">
        <div class="header-right">
            <ul>
                <li><a href="unidades.php"><i class="fas fa-building"></i> Unidades</a></li>
                <li><a href="directorio.php"><i class="fas fa-address-book"></i> Directorio</a></li>
                <li><a href="centro.php"><i class="fas fa-school"></i> Centro</a></li>
            </ul>
            <p>Síguenos en:</p>
            <div class="follow-us">
                <a href="https://www.facebook.com/UTECODR"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com/UTECODR"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/UTECODR"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/UTECODR"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="nav-panel">
        <button onclick="location.href='index.php'"><i class="fas fa-home"></i> Inicio</button>
        <button onclick="location.href='proximo_evento.php'"><i class="fas fa-calendar-alt"></i> Próximo Evento</button>
        <button onclick="location.href='#contacto'"><i class="fas fa-envelope"></i> Contacto</button>
        <button onclick="location.href='registrarse.php'"><i class="fas fa-user-plus"></i> Registrarse</button>
        <button onclick="location.href='iniciar_sesion.php'"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
    </div>
    <div class="events">
        <?php
        // Conexión a la base de datos
        require 'config.php';

        // Obtener el mes y año del próximo mes
        $nextMonth = date('m', strtotime('first day of next month'));
        $nextYear = date('Y', strtotime('first day of next month'));

        // Construir la consulta SQL para eventos del próximo mes
        $query = "SELECT * FROM eventos WHERE MONTH(fecha_inicio) = '$nextMonth' AND YEAR(fecha_inicio) = '$nextYear'";

        // Consultar eventos
        $result = $conn->query($query);

        // Mostrar eventos
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()): ?>
                <div class="event">
                    <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen del Evento" class="event-image">
                    <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                    <p><strong>Fecha de Inicio:</strong> <?php echo date('d/m/Y', strtotime($row['fecha_inicio'])); ?></p>
                    <p><strong>Fecha de Finalización:</strong> <?php echo date('d/m/Y', strtotime($row['fecha_fin'])); ?></p>
                </div>
            <?php endwhile;
        else: ?>
            <p>No se encontraron eventos para el próximo mes.</p>
        <?php endif;

        $conn->close(); ?>
    </div>
    <div class="contacto" id="contacto">
        <h2>Contacto</h2>
        <form action="enviar_contacto.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="email_contacto">Email:</label>
            <input type="email" id="email_contacto" name="email" required>
            
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
            
            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
