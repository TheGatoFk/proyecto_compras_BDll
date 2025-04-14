<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciar_sesion_usuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi cuenta - DataShop</title>
    <link rel="stylesheet" href="css/mi_cuenta.css"> <!-- Vinculamos el CSS externo -->
</head>
<body>

    <!-- Barra superior -->
    <div class="top-bar">
        <h2>DataShop</h2>
        <nav>
            <ul>
                <li><a href="panel.php">Inicio</a></li>
                <li><a href="mi_cuenta.php">Mi cuenta</a></li>
            </ul>
        </nav>
    </div>

    <!-- Contenido principal -->
    <div class="contenido">
        <h1>Mi cuenta</h1>
        <h2>Desde aquí puedes cerrar sesión</h2>
        <p><a href="salir_sesion.php">Cerrar sesión</a></p>
    </div>

    <!-- Footer -->
    <footer>
        <p>Síguenos en nuestras redes sociales:</p>
        <p>
            <a href="https://www.facebook.com" target="_blank">Facebook</a> |
            <a href="https://www.twitter.com" target="_blank">Twitter</a> |
            <a href="https://www.instagram.com" target="_blank">Instagram</a> |
            <a href="https://www.linkedin.com" target="_blank">LinkedIn</a>
        </p>
    </footer>

</body>
</html>
