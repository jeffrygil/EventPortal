<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
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
    <div class="carousel">
        <!-- Imágenes de los eventos -->
        <img src="imagenes/evento.jpg" alt="Imagen 1">
        <img src="imagenes/lugar.jpg" alt="Imagen 2">
        <img src="imagenes/aniversario.jpeg" alt="Imagen 3">
        <div class="carousel-dots">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
    <div class="search-panel">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="Buscar...">
            <button type="submit"><i class="fas fa-search"></i> Buscar</button>
        </form>
    </div>
    <div class="events">
        <?php
        // Conexión a la base de datos
        require 'config.php';

        // Obtener parámetros de búsqueda
        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

        // Obtener el mes y año actual
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Construir la consulta SQL para eventos que no han finalizado y están dentro del mes actual
        $query = "SELECT * FROM eventos WHERE fecha_fin >= CURDATE() AND MONTH(fecha_fin) = '$currentMonth' AND YEAR(fecha_fin) = '$currentYear'";

        if (!empty($search)) {
            $query .= " AND titulo LIKE '%$search%'";
        }

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
            <p>No se encontraron eventos.</p>
        <?php endif;

        $conn->close(); ?>
    </div>

    <!-- Sección de contacto -->
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

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel img');
        const dots = document.querySelectorAll('.carousel-dots .dot');

        function showImage(index) {
            images.forEach((img, i) => {
                img.style.display = i === index ? 'block' : 'none';
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        }

        document.querySelectorAll('.carousel-dots .dot').forEach((dot, i) => {
            dot.addEventListener('click', () => showImage(i));
        });

        setInterval(nextImage, 5000);
        showImage(currentIndex);
    </script>
</body>
</html>
