<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciar_sesion_usuario.php");
    exit();
}

// Obtener el nombre del usuario desde la sesión
$usuario_nombre = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi cuenta - DataShop</title>
    <link rel="stylesheet" href="css/panel.css">
</head>
<body>

    <!-- Barra superior -->
    <div class="top-bar">
        <div class="logo">
            <h2>DataShop</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="panel.php">Inicio</a></li>
                <li><a href="mi_cuenta.php">Mi cuenta</a></li>
            </ul>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="contenedor">
        <div class="titulo">
            <h1>Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?>!</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Síguenos en nuestras redes sociales:</p>
        <div class="redes-sociales">
            <a href="https://www.facebook.com" target="_blank">Facebook</a>
            <a href="https://www.twitter.com" target="_blank">Twitter</a>
            <a href="https://www.instagram.com" target="_blank">Instagram</a>
            <a href="https://www.linkedin.com" target="_blank">LinkedIn</a>
        </div>
    </footer>

</body>
</html>
