z<?php
// Iniciar la sesión al principio del archivo
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: iniciar_sesion_usuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Página Principal</title>
</head>

<body>
    <div class="Contenedor">
        <!-- Barra superior (Logo + Menú) -->
        <div class="top-bar">
            <!-- Logo -->
            <div class="logo">
                <h2>DataShop</h2>
            </div>
            <!-- Menú -->
            <div class="menu">
                <ul>
                    <li><a href="">Inicio</a></li>
                    <li><a href="mi_cuenta.php">Mi cuenta</a></li>
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Bienvenido a su cuenta</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
        </div>
    </div>
    
    <!-- Footer colocado fuera del Contenedor para que esté al final de la página -->
    <footer>
        <h3>Síguenos en nuestras redes sociales</h3>
        <div class="redes-sociales">
            <a href="https://www.facebook.com" target="_blank" title="Facebook">📘</a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter">🐦</a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram">📸</a>
            <a href="https://www.linkedin.com" target="_blank" title="LinkedIn">💼</a>
        </div>
    </footer>
</body>

</html>
