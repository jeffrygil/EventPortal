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
                <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="subir_evento.php"><i class="fas fa-upload"></i> Subir Evento</a></li>
                <li><a href="proximos_eventos.php"><i class="fas fa-calendar-alt"></i> Próximos Eventos</a></li>
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
        <button onclick="location.href='subir_evento.php'"><i class="fas fa-upload"></i> Subir Evento</button>
        <button onclick="location.href='proximos_eventos.php'"><i class="fas fa-calendar-alt"></i> Próximos Eventos</button>
    </div>
    <div class="event-list">
        <h1>Próximos Eventos</h1>
        <ul>
            <?php
            require 'config.php';
            $query = "SELECT * FROM eventos ORDER BY fecha ASC";
            $result = $conn->query($query);
            
            while ($evento = $result->fetch_assoc()) {
                echo "<li>";
                echo "<h2>" . $evento['titulo'] . "</h2>";
                echo "<p>" . $evento['descripcion'] . "</p>";
                echo "<p><strong>Fecha:</strong> " . $evento['fecha'] . "</p>";
                echo "<img src='uploads/" . $evento['imagen'] . "' alt='" . $evento['titulo'] . "'>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
