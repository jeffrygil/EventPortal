<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Evento</title>
    <link rel="stylesheet" href="menucss.css">
</head>
<body>
    <div class="header">
        <img src="imagenes/UTECO.png" alt="Logo">
        <div class="header-right">
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
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
        <button onclick="location.href='contacto.php'"><i class="fas fa-envelope"></i> Contacto</button>
        <button onclick="location.href='registrarse.php'"><i class="fas fa-user-plus"></i> Registrarse</button>
        <button onclick="location.href='iniciar_sesion.php'"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
    </div>
    <div class="registro-evento">
        <h1>Registro de Evento</h1>
        <form action="procesar_registro_evento.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen">

            <button type="submit">Registrar Evento</button>
        </form>
    </div>
</body>
</html>
