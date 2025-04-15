<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iniciar_sesion_usuario.css">
    <title>Iniciar Sesión</title>
</head>
<body>

<div class="Contenedor">
    <!-- Barra superior (Logo + Menú) -->
    <div class="top-bar">
        <div class="logo">
            <h2>DataShop</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
            </ul>
        </div>
    </div>

    <div class="titulo">
        <h1>Iniciar sesión</h1>
        <h2 class="subtitulo"></h2>
    </div>
</div>

<div class="formulario">
    <form action="sesion_usuario.php" method="post">
        <h2 class="logotipo">Ingresa tus datos</h2>
        <label for="">Email</label>
        <br>
        <input type="text" name="email" required>
        <br><br>
        <label for="">Contraseña</label>
        <br>
        <input type="password" name="contrasena" required>
        <br><br>
        <button type="submit">Continuar</button>
        <p class="crear-cuenta">
            ¿No tienes una cuenta? <a href="crear_usuario.php">Crea una aquí</a>
        </p>
    </form>
</div>

</body>
</html>
