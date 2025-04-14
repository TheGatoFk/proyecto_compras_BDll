<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nuevo_usuario.css">
    <title>Nuevo usuario</title>
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
                    <li><a href="nuevo_usuario.php">iniciar Sesion</a></li>
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Iniciar sesión</h1>
            <h2 class="subtitulo"></h2>
        </div>
    </div>

    <div class="formulario">
        <form action="usuario.php" method="post">
            <h2 class="logotipo">Crea tu cuenta</h2>
            <label for="">Nombre</label>
            <br>
            <input type="text" name="nombre">
            <br><br>
            <label for="">Apellido</label>
            <br>
            <input type="text" name="apellido">
            <br><br>
            <label for="">Email</label>
            <br>
            <input type="text" name="email">
            <br><br>
            <label for="">Telefono</label>
            <br>
            <input type="text" name="telefono">
            <br><br>
            <label for="">Direccion</label>
            <br>
            <input type="text" name="direccion">
            <br><br>
            <label for="">Contraseña</label>
            <br>
            <input type="text" name="contrasena">
            <br><br>
            <button>Crear Cuenta</button>
            
        </form>
    </div>
    
</body>
</html>