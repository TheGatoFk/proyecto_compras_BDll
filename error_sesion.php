<?php
// error_sesion.php

// Verificamos si hay un mensaje de error pasado a través de la URL
if (isset($_GET['error'])) {
    echo "<p style='color: red; text-align: center;'>Correo o contraseña incorrectos. Por favor, inténtalo de nuevo.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iniciar_sesion_usuario.css">
    <title>Error de Inicio de Sesión</title>
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
                <li><a href="index.php">Inicio</a></li>
            </ul>
        </div>
    </div>

    <div class="titulo">
        <h1>Error al iniciar sesión</h1>
        <h2 class="subtitulo"></h2>
    </div>
</div>

<div class="formulario">
    <form action="sesion_usuario.php" method="post">
        <h2 class="logotipo">Vuelve a ingresa tus datos</h2>
        <label for="">Email</label>
        <br>
        <input type="text" name="email" required>
        <br><br>
        <label for="">Contraseña</label>
        <br>
        <input type="password" name="contrasena" required>
        <br><br>
        <button>Continuar</button>
    </form>
</div>

</body>
</html>
